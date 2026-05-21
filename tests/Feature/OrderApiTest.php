<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Client;
use App\Models\Order;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderApiTest extends TestCase
{
    // Каждый тест использует свежую БД (миграции накатываются заново)
    use RefreshDatabase;

    /**
     * Тест 1: Неавторизованный пользователь не получает список заказов.
     */
    public function test_unauthenticated_user_cannot_access_orders(): void
    {
        // Отправляем GET-запрос к API без токена
        $response = $this->getJson('/api/orders');
        // Ожидаем статус 401 (Unauthorized)
        $response->assertStatus(401);
    }

    /**
     * Тест 2: Авторизованный пользователь видит только свои заказы.
     */
    public function test_authenticated_user_can_get_own_orders(): void
    {
        // Создаём обычного пользователя
        $user = User::factory()->create(['role' => User::ROLE_USER]);
        // Эмулируем его аутентификацию через Sanctum
        Sanctum::actingAs($user);

        // Создаём клиента, привязанного к этому пользователю
        $client = Client::factory()->create(['user_id' => $user->id]);
        // Создаём 3 заказа, принадлежащих этому пользователю
        Order::factory()->count(3)->create([
            'client_id' => $client->id,
            'user_id'   => $user->id,
        ]);

        // Создаём другого пользователя, его клиента и один заказ (чужие данные)
        $otherUser = User::factory()->create(['role' => User::ROLE_USER]);
        $otherClient = Client::factory()->create(['user_id' => $otherUser->id]);
        Order::factory()->create([
            'client_id' => $otherClient->id,
            'user_id'   => $otherUser->id,
        ]);

        // Запрашиваем список заказов
        $response = $this->getJson('/api/orders');
        // Статус должен быть 200 OK
        $response->assertStatus(200);
        // В JSON-ответе в поле 'data' должно быть ровно 3 заказа (свои)
        $response->assertJsonCount(3, 'data');
    }

    /**
     * Тест 3: Обычный пользователь не может обновить чужой заказ.
     */
    public function test_user_cannot_update_foreign_order(): void
    {
        // Создаём двух обычных пользователей
        $user      = User::factory()->create(['role' => User::ROLE_USER]);
        $otherUser = User::factory()->create(['role' => User::ROLE_USER]);

        // Создаём клиента и заказ, принадлежащие другому пользователю
        $client = Client::factory()->create(['user_id' => $otherUser->id]);
        $order  = Order::factory()->create([
            'client_id' => $client->id,
            'user_id'   => $otherUser->id,
        ]);

        // Аутентифицируемся под первым пользователем
        Sanctum::actingAs($user);

        // Пытаемся обновить чужой заказ
        $response = $this->putJson("/api/orders/{$order->id}", [
            'title'     => 'Hacked',
            'amount'    => 999,
            'client_id' => $client->id,
        ]);
        // Ожидаем 403 Forbidden (доступ запрещён политикой)
        $response->assertStatus(403);
    }

    /**
     * Тест 4: Администратор может обновить любой заказ (в том числе чужой).
     */
    public function test_admin_can_update_any_order(): void
    {
        // Создаём администратора и обычного пользователя
        $admin     = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $otherUser = User::factory()->create(['role' => User::ROLE_USER]);

        // Создаём клиента и заказ, принадлежащие обычному пользователю
        $client = Client::factory()->create(['user_id' => $otherUser->id]);
        $order  = Order::factory()->create([
            'client_id' => $client->id,
            'user_id'   => $otherUser->id,
        ]);

        // Аутентифицируем администратора
        Sanctum::actingAs($admin);

        // Обновляем заказ (который принадлежит другому пользователю)
        $response = $this->putJson("/api/orders/{$order->id}", [
            'title'     => 'Updated by admin',
            'amount'    => 1000,
            'client_id' => $client->id,
        ]);
        // Админ должен иметь право, статус 200 OK
        $response->assertStatus(200);
        // Дополнительно проверяем, что название действительно изменилось в БД
        $this->assertEquals('Updated by admin', $order->fresh()->title);
    }
}
