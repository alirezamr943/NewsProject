<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SaveNews implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $client = new Client();
        $apiKey1 = "22260956290043d48547fd7d8b428acb";
        $apiKey2 = "45G2qhKkGvBJAUNIMjAgvSTQzpErFMy1";
        // getting data from NEWS API
        try {
            $res1 = $client->request('GET', "https://newsapi.org/v2/everything?q=keyword&apiKey=" . $apiKey1);
            $dataArray = json_decode($res1->getBody()->getContents());
            foreach ($dataArray->articles as $key => $article) {
                DB::table('news')->insert([
                    "author" => $article->author ?? "empty",
                    "title" => $article->title,
                    "description" => $article->description,
                    "published_date" => date('Y-m-d h:i:s', strtotime($article->publishedAt)),
                    "source" => $article->url,
                    "type" => "default"
                ]);
                if ($key == 9) {
                    break;
                }
            }
        } catch (\Exception $e) {
            Log::error($e);
        }

        // getting data from NY TIMES
        try {
            $res2 = $client->request('GET', "https://api.nytimes.com/svc/mostpopular/v2/emailed/7.json?api-key=" . $apiKey2);
            $dataArray = json_decode($res2->getBody()->getContents());
            foreach ($dataArray->results as $key => $article) {
                // var_dump($article->byline . "<br>");
                DB::table('news')->insert([
                    "author" => $article->byline ?? "empty",
                    "title" => $article->title,
                    "description" => $article->abstract,
                    "published_date" => date('Y-m-d h:i:s', strtotime($article->published_date)),
                    "source" => $article->url,
                    "type" => $article->type
                ]);
                if ($key == 9) {
                    break;
                }
            }
        } catch (\Exception $e) {
            Log::error($e);
        }


        Cache::rememberForever('save_news', function () {
            return now()->toDateTimeString();
        });
    }
}
