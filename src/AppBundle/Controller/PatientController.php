<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Patient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * Patient controller.
 *
 * @Route("patient")
 */
class PatientController extends Controller
{
    /**
     * Lists all patient entities.
     *
     * @Route("/", name="patient_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $patients = $em->getRepository('AppBundle:Patient')->findAll();

        /** @var Serializer $serializer */
        $serializer = $this->container->get('serializer');
        $patients = $serializer->serialize($patients, 'json');

        return new Response($patients);
    }

    /**
     * Creates a new patient entity.
     *
     * @Route("/new", name="patient_new")
     * @Method({"POST"})
     */
    public function newAction(Request $request)
    {
        $patientData = json_decode($request->getContent(), true);

        $patient = new Patient();
        $patient->fillFromArray($patientData);

        /** @var ConstraintViolation[] $errors */
        $errors = $this->get('validator')->validate($patient);

        if (count($errors) > 0) {

            $messages = [];
            foreach ($errors as $error) {
                $messages[$error->getPropertyPath()] = $error->getMessage();
            }

            return new JsonResponse(['errors' => $messages], 400);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($patient);
        $em->flush();

        return new JsonResponse(null, 201);
    }

    /**
     * Finds and displays a patient entity.
     *
     * @Route("/{id}", name="patient_show")
     * @Method("GET")
     */
    public function showAction(Patient $patient)
    {
        /** @var Serializer $serializer */
        $serializer = $this->container->get('serializer');
        $patient = $serializer->serialize($patient, 'json');

        return new Response($patient);
    }

    /**
     * Displays a form to edit an existing patient entity.
     *
     * @Route("/{id}/edit", name="patient_edit")
     * @Method({"PUT"})
     */
    public function editAction(Request $request, Patient $patient)
    {
        $patientData = json_decode($request->getContent(), true);
        $patient->fillFromArray($patientData);

        /** @var ConstraintViolation[] $errors */
        $errors = $this->get('validator')->validate($patient);

        if (count($errors) > 0) {

            $messages = [];
            foreach ($errors as $error) {
                $messages[$error->getPropertyPath()] = $error->getMessage();
            }

            return new JsonResponse(['errors' => $messages], 400);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($patient);
        $em->flush();

        return new JsonResponse(null, 200);
    }

    /**
     * Deletes a patient entity.
     *
     * @Route("/{id}/delete", name="patient_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $patient = $em->getRepository('AppBundle:Patient')->find($id);

        if (!$patient) {
            return new JsonResponse(null, 404);
        }

        $em->remove($patient);
        $em->flush();

        return new JsonResponse(null, 200);
    }
}
