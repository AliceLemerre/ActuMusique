<?php
namespace App\Controllers;

use App\Core\View;

class Dashboard
{
    public function index(): void
    {
        $myView = new View("Dashboard/dashboard", "back");
    }

    public function pages(): void
    {
        $myView = new View("Dashboard/pagesList", "back");
    }

    public function posts(): void
    {
        $myView = new View("Dashboard/dashboard-posts", "back");
    }

    public function comments(): void
    {
        $myView = new View("Dashboard/commentsList", "back");
    }

    public function accounts(): void
    {
        $myView = new View("Dashboard/accountslist", "back");
    }

    public function design(): void
    {
        $myView = new View("Dashboard/design", "back");
    }

    public function medias(): void
    {
        $myView = new View("Dashboard/mediasList", "back");
    }

    private function getLastSixMonthsComments(): array
    {

        $security = new Security();
        $isAdmin = $security->checkAuthentification('/');
        if ($isAdmin == "admin") {


            $dataForChart = [];

            for ($i = 0; $i < 6; $i++) {
                $startDate = (new \DateTime())->modify('-' . $i . ' months')->modify('first day of this month');
                $endDate = (new \DateTime())->modify('-' . $i . ' months')->modify('last day of this month');

                $comment = new Comment();

                $commentCount = $comment->countWithParamsBetween('created_at', $startDate->format('Y-m-d H:i:s'), $endDate->format('Y-m-d H:i:s'));
                $dataForChart[$startDate->format('F Y')] = $commentCount;
            }

            $dataForChart = array_reverse($dataForChart);

            return array_values($dataForChart);
        } else {
            header('location:/login');
            exit();
        }
    }
}
