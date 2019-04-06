<?php

namespace Drupal\the_entertainment_openlibrary\Controller;

use Drupal\Core\Controller\ControllerBase;
use GuzzleHttp\Exception\RequestException;

/**
 * Class BookResultsController.
 */
class BookResultsController extends ControllerBase {

  /**
   * Book_results.
   *
   */
  public function book_results() {

    // Get query parameters from URL
    $parameters = \Drupal::request()->query->all();
    $terms = []; // Initialize empty terms array

    // Check if title/author/keyword query present
    if (array_key_exists('title', $parameters) ||
      array_key_exists('author', $parameters) ||
      array_key_exists('keywords', $parameters)) {

      // Use Open Library Search API
      $endpoint = 'http://openlibrary.org/search.json';

      // Set keyword query terms
      if (array_key_exists('keywords', $parameters)) {
        $terms['q'] = $parameters['keywords'];
      }

      // Set title query terms
      if (array_key_exists('title', $parameters)) {
        $terms['title'] = $parameters['title'];
      }

      // Set author query terms
      if (array_key_exists('author', $parameters)) {
        $terms['author'] = $parameters['author'];
      }
    }

    // Check if ISBN query present
    elseif (array_key_exists('isbn', $parameters)) {

      // Use Open Library Books API
      $endpoint = 'https://openlibrary.org/api/books';

      // Set ISBN query
      $terms['bibkeys'] = 'ISBN:' . $parameters['isbn'];
    }

    // Otherwise, the query terms aren't valid
    else {
      return [
        '#type' => 'markup',
        '#markup' => t('No valid search terms provided.')
      ];
    }

    // Initialize Guzzle HTTP client
    $client = \Drupal::httpClient();
    try {
      $request = $client->get($endpoint, ['query' => $terms]);  // make API call
      $response = $request->getBody()->getContents(); // get JSON content
      $contents = (array)json_decode($response);  // convert JSON to array
      if ($contents['numFound'] > 0) {
        $books = [];
        foreach ($contents['docs'] as $doc) {
          $book = [];
          if (isset($doc->edition_key)) {
            if (isset($doc->title)) {
              $book['title'] = $doc->title;
            }
            if (isset($doc->subtitle)) {
              $book['title'] .= ': ' . $doc->subtitle;
            }
            if (isset($doc->author_name)) {
              $book['authors'] = $doc->author_name;
            }
            if (isset($doc->first_publish_year)) {
              $book['year'] = $doc->first_publish_year;
            }
            $book['olid'] = $doc->edition_key[0];
            array_push($books, $book);
          }
        }
      }
      else {
        return [
          '#type' => 'markup',
          '#markup' => 'No books matched your search terms.'
        ];
      }
    }
    catch (RequestException $e) {
      // If search fails, display error as Drupal status message and log to watchdog
      watchdog_exception('the_entertainment_openlibrary', $e, $e->getMessage());
    }
    return [
      '#type' => 'markup',
      '#markup' => t('hi'),
    ];
  }
}
