<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;

class SearchController extends Controller
{
    public function search(Request $request)
    {       
        $url = $this->buildUrl($request);
     
      
        $client = new Client();
        $crawler = $client->request('GET', $url);

        

        $numberPages = $crawler->filter('.total')->each(function ($node) {
            return $node->text();
        });
   
        $vehicles[] = $this->getVehicles($crawler);
            
        if($numberPages > 1){
            for ($x = 2; $x <= (int)$numberPages; $x++) {
                $crawler = $client->request('GET', $url . "/pagina/" . $x);
                $vehicles[] = $this->getVehicles($crawler);
               
            } 
        }      

        if (empty($vehicles)){
            throw new NotFoundHttpException();
        }

        return  $vehicles;
    }

    public function getVehiclesDetails($link)
    {       
        $parts = explode('/', $link);
      
        $detail = app('App\Http\Controllers\DetailController')->detail($parts[2],$parts[3],$parts[4],$parts[5]);
    
        return $detail;
    }

    public function getVehicles($crawler)
    {
        $names = $crawler->filter('.bg-busca .titulo-busca')->each(function ($node) {
            $names[] = trim($node->text());
            
            return $names;
        });
        
        $prices = $crawler->filter('.preco_busca')->each(function ($node) {
            $prices[] = trim($node->text());
            return $prices;
        });

        $links = $crawler->filter('.bg-busca > dt')->filterXPath('//a[contains(@href, "")]')->each(function ($node) {
            return $links[] = $node->extract(['href'])[0];
        });

        $p = $crawler->filter('p')->each(function ($node) {
            return $node->text();
        });

        foreach($p as $key => $value){
            if (strpos($value, 'Km') !== false){
                $km[] =  str_replace("\n", "", $value);
            }
        }


        foreach($links as $key => $link){
           $stripLinks[]= substr($link, 0, strrpos( $link, '/') );
        }
   
        
        $i =0;
        foreach($stripLinks as $key => $link){
            $parts = explode('/', $link);
          
            $details['brand']  = $parts[2];
            $details['model']  = $parts[3];
            $details['year']   = $parts[4];
            $details['id']     = $parts[5];
            $details['price']  = $prices[$i];
            $details['km']     = $km[$i];
            $i++;

            $vehicles[] = $details;
        }
        return $vehicles;
    }

    public function buildUrl($request)
    {   
        $url    = "https://www.seminovosbh.com.br/resultadobusca/index/veiculo/";
        # carro/estado-conservacao/0km/marca/Chevrolet/modelo/1367/valor1/2000/valor2/60000/ano1/1981/ano2/2019/usuario/revenda
        if($request->has('type')){
            $url = $url . $request->get('type');
        }

        if($request->has('condition')){
            $url = $url ."/estado-conservacao/". $request->get('condition');
        }

        if($request->has('brand')){
            $url = $url ."/marca/". $request->get('brand');
        }

        if($request->has('model')){
            $url = $url ."/modelo/".$request->get('model');
        }

        if($request->has('value1')){
            $url = $url ."/valor1/". $request->get('value1');
        }

        if($request->has('value2')){
            $url = $url ."/valor2/". $request->get('value2');
        }

        if($request->has('year1')){
            $url = $url ."/year1/". $request->get('year1');
        }

        if($request->has('year2')){
            $url = $url ."/year2/".$request->get('year2');
        }

        if ($request->has('city')) {
            $url = $url . "/cidade/". $request->get('city');
        }

        if($request->has('user')){
            $url = $url ."/usuario/". $request->get('user');
        }

        return $url;
    }

    

    
}