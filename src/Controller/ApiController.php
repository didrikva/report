<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/', name: 'mig')]
    public function home(): Response
    {
        return $this->render('mig.html.twig');
    }

    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route('/report', name: 'report')]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

    #[Route('/api', name: 'api')]
    public function api(): Response
    {
        $data = [
            'quotes' => 'Route about me',
        ];

        return $this->render('api.html.twig', $data);
    }
    #[Route("/lucky/number/twig", name: "lucky_number")]
    public function number(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'number' => $number
        ];

        return $this->render('lucky_number.html.twig', $data);
    }
    #[Route('/api/quote', name: 'quote')]
    public function apijson(): JsonResponse
    {
        $number = random_int(0, 2);
        $quotes = [
            'If Roman Abramovich helped me out in training we would be bottom of the league and if I had to work in his world of big business, we would be bankrupt!',
            'No club moves me from Chelsea until Chelsea wants me to move because I want to be where I am loved.',
            'When I came to Chelsea from West Ham there were certain parts of my game I felt I needed to improve and I like to think now that I have shown dramatic improvement.',
        ];
        $timestamp = date('Y-m-d H:i:s');
        $date = date('Y-m-d');
        $quote = $quotes[$number];
        $response = new JsonResponse([
            'quote' => $quote,
            'date' => $date,
            'timestamp' => $timestamp]);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
    #[Route('/lucky', name: 'lucky')]
    public function lucky(): Response
    {
        $number = random_int(0, 80);
        $facts = [
            'Chelsea FC grundades 1905.',
            'Klubben spelar sina hemmamatcher på Stamford Bridge.',
            'Stamford Bridge har varit Chelseas hem sedan klubben grundades.',
            'Chelsea vann sin första ligatitel säsongen 1954/55.',
            'Blått är Chelseas traditionella hemmatröjsfärg.',
            "Chelsea kallas ofta 'The Blues'.",
            "Klubbens smeknamn inkluderar även 'The Pensioners' från deras äldre logotyp.",
            'Chelsea har vunnit UEFA Champions League två gånger (2012, 2021).',
            'Didier Drogba gjorde det avgörande målet i Champions League-finalen 2012.',
            'Chelsea har vunnit Premier League fem gånger.',
            'Chelsea är en av de mest framgångsrika engelska klubbarna under 2000-talet.',
            'Klubben ägs av Todd Boehly och Clearlake Capital sedan 2022.',
            'Roman Abramovich köpte Chelsea 2003 och ledde klubben till stora framgångar.',
            'Chelsea vann sin första FA-cuptitel 1970.',
            'Chelsea har vunnit FA-cupen åtta gånger.',
            'Klubben har även vunnit UEFA Europa League två gånger (2013, 2019).',
            'Chelsea har vunnit Ligacupen fem gånger.',
            'Chelsea vann UEFA Super Cup 2021 efter att ha besegrat Villarreal.',
            'Frank Lampard är Chelseas bästa målskytt genom tiderna med 211 mål.',
            'Petr Čech har rekordet för flest nollor (clean sheets) i klubbens historia.',
            'Gianfranco Zola anses vara en av de största Chelsea-spelarna genom tiderna.',
            'John Terry var Chelseas lagkapten i nästan två decennier.',
            "José Mourinho kallades 'The Special One' när han tog över Chelsea 2004.",
            'Mourinho ledde Chelsea till två raka ligatitlar 2004/05 och 2005/06.',
            'Chelsea slog poängrekord i Premier League 2004/05 med 95 poäng.',
            'Chelsea är en av endast sex engelska klubbar som har vunnit Champions League.',
            'Eden Hazard vann PFA Player of the Year 2015.',
            'Chelsea var den första Londonklubben att vinna Champions League.',
            'Chelsea har en långvarig rivalitet med Arsenal, Tottenham och Fulham.',
            'Londonderbyt mellan Chelsea och Tottenham är ofta intensivt.',
            'Chelsea vann Community Shield 2005 genom att besegra Arsenal.',
            'Chelsea har vunnit FIFA Club World Cup (2021).',
            'Chelsea har en akademi som har producerat spelare som Mason Mount och Reece James.',
            'Reece James blev lagkapten för Chelsea 2023.',
            'Chelsea har spelat i Englands högsta division nästan hela sin historia.',
            'Chelsea slog rekord genom att värva Kepa Arrizabalaga för 72 miljoner pund 2018.',
            'Didier Drogba har gjort flest mål i finaler för Chelsea.',
            'Chelsea slog Barcelona i Champions League-semifinalen 2012.',
            'Chelsea vann Champions League 2021 efter att ha besegrat Manchester City.',
            'Thomas Tuchel tog över Chelsea 2021 och ledde dem till Champions League-titeln.',
            'Chelsea vann sin första stora europeiska titel, Cupvinnarcupen, 1971.',
            'Ron Harris har gjort flest matcher för Chelsea (795).',
            'Chelsea hade en obesegrad hemmarekord i Premier League mellan 2004-2008.',
            'Chelsea blev den första klubben att använda tröjreklam i England (Gulf Air 1983).',
            'Chelsea slog rekord för högsta transferutgifter under ett transferfönster 2022.',
            'Chelsea vann sin första dubbel (liga + FA-cup) 2009/10.',
            'Antonio Conte ledde Chelsea till Premier League-titeln 2016/17.',
            'Chelsea har haft mer än 30 olika tränare sedan starten.',
            'José Mourinho har vunnit flest Premier League-titlar med Chelsea (3).',
            'Maurizio Sarri ledde Chelsea till en Europa League-titel 2019.',
            'Chelsea hade rekordet för den dyraste försvararen (Ben Chilwell 50M pund, 2020).',
            'Chelsea har haft spelare från över 50 olika länder.',
            'Chelsea har haft ikoniska spelare som Claude Makélélé, Michael Essien och Ashley Cole.',
            'Michael Ballack spelade för Chelsea mellan 2006 och 2010.',
            "Chelsea har haft flera Ballon d'Or-nominerade spelare genom åren.",
            'Fernando Torres gjorde ett berömt mål mot Barcelona i Champions League 2012.',
            'Chelsea har aldrig åkt ur Premier League sedan den startade 1992.',
            'Rivaliteten mellan Chelsea och Leeds United är en av de äldsta i engelsk fotboll.',
            'Chelsea värvade Andriy Shevchenko för ett då rekordbelopp 2006.',
            'Chelsea vann en av sina största segrar 8-0 mot Wigan 2010.',
            'Chelsea har värvat flera brasilianska stjärnor, inklusive Thiago Silva och Oscar.',
            'Roman Abramovichs pengar förändrade Chelsea och engelsk fotboll.',
            'Chelsea blev den första klubben att ha en rysk ägare i Premier League.',
            'Chelsea spelade sin första match någonsin mot Stockport County 1905.',
            'Chelsea var en av de första klubbarna att använda ett flygbolag som sponsor.',
            'Chelsea har ett av de högsta lönetak i Premier League.',
            'Chelsea har spelat i över 30 FA-cupfinaler.',
            'Chelsea slog rekord för flest mål i en Premier League-säsong (103, 2009/10).',
            'Chelsea har haft flera legendariska nummer 9-spelare, men många har misslyckats.',
            'Chelsea värvade N’Golo Kanté från Leicester City 2016.',
            'Chelsea blev den första klubben att vinna Champions League med en tysk tränare (Tuchel).',
            'Chelsea har spelat i flera europeiska finaler på neutral mark.',
            'Chelsea har haft flera ikoniska bortatröjor genom åren.',
            'Chelsea har en av de största supporterbaserna i världen.',
            'Chelsea vann 2012 Champions League-finalen genom att besegra Bayern München på straffar.',
            'Chelsea slog Manchester United på straffar i FA-cupfinalen 2007.',
            'Chelsea har varit en pionjär när det gäller att värva afrikanska spelare till Europa.',
            'Chelsea är kända för att ha en stark ungdomsakademi.',
            'Chelsea har haft fler än 10 olika tröjtillverkare genom tiderna.',
            'Chelsea vann sin första titel på 50 år under José Mourinho 2004/05.',
            'Under säsongen 2004/05 släppte Chelsea in endast 15 mål på hela Premier League-säsongen, ett rekord som fortfarande står kvar.',
        ];
        $data = [
            'number' => $number,
            'fakta' => $facts,
        ];

        return $this->render('lucky_number.html.twig', $data);
    }
}