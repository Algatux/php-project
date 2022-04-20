<?php declare(strict_types=1);

namespace App\Controller;

use App\Event\TransactionCreated;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home_index')]
    public function index(EventDispatcherInterface $eventDispatcher): Response
    {
        $eventDispatcher->dispatch(new TransactionCreated());

        return $this->render('home/home.html.twig');
    }
}
