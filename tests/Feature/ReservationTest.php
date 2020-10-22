<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use \App\Book;

class ReservationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'My Book',
            'author' => 'Shams',
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    /** @test **/
    public function a_title_is_required()
    {
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Shams',
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test **/
    public function an_uthor_is_required()
    {
        $response = $this->post('/books', [
            'title' => 'Da vinci code',
            'author' => '',
        ]);

        $response->assertSessionHasErrors('author');
    }

    /** @test **/
    public function a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'Da vinci code',
            'author' => 'Dan Brown',
        ]);

        $book = Book::first();

        $response = $this->patch('/books/'. $book->id, [
            'title' => 'New Title',
            'author' => 'New Author',
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);
    }
}
