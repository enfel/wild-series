<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Season;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;

/**
 * @Route("/program", name="program_")
 */

class ProgramController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()->getRepository(Program::class)->findAll();
        return $this->render('program/index.html.twig', ['programs' => $programs]);
    }

    /**
     * @Route("/show/{id<^[0-9]+$>}", name="show")
     * @return Response
     */
    public function show(int $id): Response
    {
        $program = $this->getDoctrine()->getRepository(Program::class)->findOneBy(['id' => $id]);
        $seasons = $this ->getDoctrine()->getRepository(Season::Class)->findAll();

        if (!$program) {
            throw $this->createNotFoundException('No program with id : ' . $id . ' found in program\'s table.');
        }
        return $this->render('program/show.html.twig', ['program' => $program, 'seasons' => $seasons]);
    }
    /**
     * @Route("/{programId<^[0-9]+$>}/seasons/{seasonId<^[0-9]+$>}", name="season_show")
     * @return Response
     */
    public function showSeason(int $programId, int $seasonId): Response
    {
        $program = $this->getDoctrine()->getRepository(Program::class)->findOneBy(['id' => $programId]);
        $season = $this ->getDoctrine()->getRepository(Season::Class)->findOneBy(['id' => $seasonId]);
        $episodes = $this->getDoctrine()->getRepository(Episode::class)->findBy(['season' => $season], ['id' => 'ASC']);



        return $this->render('program/season_show.html.twig', ['program' => $program, 'season' => $season, 'episodes'=>$episodes]);
    }
}
