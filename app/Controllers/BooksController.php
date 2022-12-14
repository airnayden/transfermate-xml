<?php

namespace App\Controller;

use Illuminate\Database\Capsule\Manager as Capsule;

class BooksController extends BaseController
{
    /**
     * @param array $params
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index(array $params = []): void
    {
        // Sanitization is handled by the ORM package when building the queries, no no need to perform it here.
        $filter = $params['filter'] ?? null;

        $query = Capsule::table('authors')
            ->select('authors.id', 'authors.name', 'books.name as book')
            ->leftJoin('books', 'books.author_id', '=', 'authors.id');

        if (!is_null($filter)) {
            $query->whereRaw('LOWER(authors.name) LIKE ?', ['%' . trim(mb_strtolower($filter)) . '%']);
            $query->orWhereRaw('LOWER(books.name) LIKE ?', '%' . trim(mb_strtolower($filter)) . '%');
        }

        $results = $query->get();

        // Render output
        $header = $this->output->load('common/header.twig')->render([
            'filter' => $filter
        ]);
        $footer = $this->output->load('common/footer.twig')->render();
        $booksIndex = $this->output->load('books/index.twig');

        print html_entity_decode($booksIndex->render([
            'header' => $header,
            'footer' => $footer,
            'filter' => $filter,
            'results' => $results->toArray()
        ]));
    }
}