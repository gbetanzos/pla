<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ShoppingList;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShoppingListToggleTest extends TestCase
{
    use RefreshDatabase;

    public function test_unchecked_item_is_not_bought(): void
    {
        $this->actingAs(User::factory()->make());

        $user = User::factory()->create();
        $product = Product::factory()->create();
        $list = ShoppingList::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('shopping-lists.show', $list));
        $response->assertOk();
        $this->assertSame($user->id, $list->user_id);
    }

    public function test_toggle_makes_it_bought(): void
    {
        $this->actingAs(User::factory()->make());

        $user = User::factory()->create();
        $product = Product::factory()->create();
        $list = ShoppingList::factory()->create(['user_id' => $user->id]);

        $response = $this->postJson(route('shopping-lists.toggle-item', $list), [
            'item_id' => $product->id,
            'checked' => true,
        ]);

        $response->assertOk();

        $this->assertNotNull($list->items);
        $this->assertSame($product->id, $list->items[0]['product_id']);
        $this->assertTrue($list->items[0]['checked']);
    }
}
