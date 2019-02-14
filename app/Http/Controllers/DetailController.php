<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;

class DetailController extends Controller
{
    public function detail($manufacturer,$model,$year,$id)
    {       
        $url        = "https://www.seminovosbh.com.br/comprar/$manufacturer/$model/$year/$id";
        $content    = file_get_contents($url);
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $details = $crawler->filter('span[itemprop="description"] li')->each(function ($node) {
            $details[] = trim($node->text());
            return $details;
        });

        $acessories = $crawler->filter('#infDetalhes2 ul')->each(function ($node) {
            $acessories[] = trim($node->text());
            return $acessories;
        });

        $moreDetails = $crawler->filter('#infDetalhes3 ul p')->each(function ($node) {
            return $node->text();
        });
                      
        $data['model']          = $model;
        $data['manufacturer']   = $manufacturer;
        $data['year']           = $year;
        $data['id']             = $id;
        $data['details']        = $details;
        $data['acessories']     = $acessories;
        $data['more_details']   = $moreDetails;

        if (empty($data)){
            throw new NotFoundHttpException();
        }
        $data = json_encode($data);     
        
        return response($data, 200);
    }

    
}