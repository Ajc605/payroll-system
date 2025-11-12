<?php

namespace App\Controller;

use App\Form\PayrollCalculatorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PayrollUiController extends AbstractController
{
    #[Route('/', name: 'payroll_calculator')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(PayrollCalculatorType::class);

        return $this->render('payroll/calculator.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
