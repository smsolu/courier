<?php

namespace AppBundle\Controller\Expediente;

use DateTime;
//use Exception;
use AppBundle\Entity\Expediente;
use AppBundle\Entity\UsuarioExpediente;
use ListViewBundle\Services\LinkColumn;
use ListViewBundle\Services\ListView;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

    /**
     * @Route("")
     */
class ExpedienteFavoritoController extends Controller
{
   /**
     * @Route("/expedientefavoritos/list/{page}/{resultpage}/{order_col}/{order_status}", defaults={"page" = 1, "resultpage" = 10,"order_col"="","order_status"=1}, name="expedientefavoritos_list")
     * @Template("ExpedienteBundle:ExpedienteFavorito:listExpedienteFavorito.html.twig")
     */
    public function listExpedienteFavoritoAction(Request $request, 
                               $page,$resultpage,$order_col,$order_status)
    {
        // Muestra los eventos de la agenda de un expediente
        $usuario = $this->getUser();
        $estudio = $usuario->getEstudio();
        $em = $this->getDoctrine()->getManager();

        // 1. Crear el Query del Listado.
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder
            ->select('u')
            ->from('CommonBundle:UsuarioExpediente','u')
            ->innerJoin('u.Expediente', 'e')
            ->where("e.status = 0 and u.Usuario =:usuario and u.Estudio = :estudio ")
            ->setParameters(array("estudio"=>$estudio, "usuario"=>$usuario))
            ->orderBy("u.fechaultimoingreso", "DESC");
  

        // 2. Usar los filtros y la búsqueda
//        $findManager = $this->get('legalPro_commonBundle_FindManager');
//        $exp_find = new ExpedienteFindType;
//        $findManager = $exp_find->getParameters($request, $queryBuilder,$findManager);
//        $findManager->showFilters($this,$queryBuilder,true);

        //3. Generar el ListView con las columnas a mostrar
        $list = new ListView();
        $list
            ->setTitle("Expedientes Favoritos")
            ->setControllerParent($this)
            ->addColumn('', 'id',array(
                        'type' => 'link',
                        'route' => new LinkColumn('expediente_show', array('id'=> 'getExpedienteid')),
                        'value' => '<span class="glyphicon glyphicon-eye-open"></span>',
                        )
            )
            ->addColumn('Ult. Ingreso', 'fechaultimoingreso',array(
                'type' => 'datetime',
                'allow_order'=>'0',
                ))
            ->addColumn("Expediente", 'Expediente.getNumeroyCaratulaCompleto',array(
                'type' => 'object',
                'type2' => 'string',
                'allow_order'=>'0',
                ))                
            ->setPage($page)
            ->setResultPage($resultpage)
            ->setQueryBuilder($queryBuilder)
            ->setOrderCol($order_col, $order_status);
        
        //. Enviar la información a la vista
        return array('list' => $list,'request'=>$request,'parameters'=>$this->getRequest()->query->all()
                );
        
    }    
    

    
    
    /**
     * @Route("/Agenda/widget", defaults={}, name="agenda_widget")
     * @Template("ExpedienteBundle:Agenda:showWidget.html.twig")
     */
    public function showWidgetAction()
    {
        $estudio = $this->getUser()->getEstudio();
        $em = $this->getDoctrine()->getManager();

        
        $fecha1 = date("d-m-Y");
        $fecha2 = date("d-m-Y");
        
        /* Convertir fechas */
        $fecha1_convertida =DateTime::createFromFormat('d-m-Y', $fecha1);
        if(!$fecha1_convertida){
            $fecha1_convertida = DateTime::createFromFormat('d-m-Y', "1-1-1900");
        }
        $fecha2_convertida =DateTime::createFromFormat('d-m-Y', $fecha2);
        if(!$fecha2_convertida){
            $fecha2_convertida = DateTime::createFromFormat('d-m-Y', "1-1-2100");
        }            
        
        // 1. Crear el Query del Listado.
        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder
            ->select('e')
            ->from('CommonBundle:AgendaFecha','e')
            ->innerJoin('e.AgendaEvento', 'p')
            ->where("e.fecha between :fecha1 and :fecha2 and p.status = 0 "
                    . "and e.Estudio = :estudio")
            ->setParameters(array("fecha1"=> $fecha1_convertida->format('Y-m-d 00:00:00'),"fecha2"=> $fecha2_convertida->format('Y-m-d 23:59:59'), 
                            "estudio"=>$estudio))
            ->orderBy("p.horainicio", "DESC")
            ->setMaxResults(3);
        $eventos = $queryBuilder->getQuery()->getResult();

        
        $qb =  $em->createQueryBuilder();
        $qb->select('count(e.id)');
        $qb->from('CommonBundle:AgendaFecha','e');
        $qb->where("e.Estudio = :estudio and e.fecha between :fecha1 and :fecha2");
        $qb->setParameters(array("fecha1"=> $fecha1_convertida->format('Y-m-d 00:00:00'),"fecha2"=> $fecha2_convertida->format('Y-m-d 23:59:59'), 
                                "estudio"=>$estudio));
        $cant = $qb->getQuery()->getSingleScalarResult();        

    
        
        
        return array('eventos'=>$eventos, 'cant'=>$cant);
    }
    
    
    /**
     * Route("/expedientefavorito/{expedienteid}/{valor}/{route}", defaults={"route" = ""}, name="expediente_favorito")
     * Template()
     */
//    public function ExpedienteFavoritoAction($expedienteid, $valor, $route=""){
//        //VALOR = 0, LO SACA DE FAVORITO || VALOR = 1, LO AGREGA
//        $usuario = $this->getUser();
//        $estudio = $usuario->getEstudio();
//        $em = $this->getDoctrine()->getManager();
//        $repository = $this->getDoctrine()->getRepository('AppBundle:Expediente');
//        $expediente = $repository->find($expedienteid);
//        
//        
//        
//        $repository = $this->getDoctrine()->getRepository('CommonBundle:UsuarioExpediente');
//        $expedienteFavorito  = $repository->findOneBy(Array("Expediente"=>$expediente, 
//                                                "Estudio"=>$estudio, "Usuario"=>$usuario));
//        
//        
//        if($valor == 1){
//            if(!$expedienteFavorito){  // Solo crea cuando no se encuentre el expediente
//                $expedienteFavorito = new UsuarioExpediente();
//                $expedienteFavorito->setEstudio($estudio);
//                $expedienteFavorito->setExpediente($expediente);
//                $expedienteFavorito->setUsuario($usuario);
//                $em->persist($expedienteFavorito);
//                $em->flush();
//            }
//        }else{
//            if($expedienteFavorito){ //Solo borra cuando exista el expediente
//
//                $em->remove($expedienteFavorito);
//                $em->flush();
//            }
//        }
//        if($route===""){
//            //$route = $this->generateUrl("expediente_show", array("id"=> $expedienteid, "seccion"=> "General"));
//            return $this->redirectToRoute('expediente_show', array('id'=>$expedienteid, 'seccion'=>'General'), 301);
//        }
//        
//        return $this->redirect($route);
//    }
    
    /**
     * Si esta en favorito lo saca, si no lo esta lo agrega
     * @Route("/setexpedientefavorito/{id}/{route}", defaults={"route" = ""}, name="set_expediente_favorito")
     * @Template()
     */
    public function setExpedienteFavoritoAction(Expediente $expediente, $route){
        
        if(!$expediente || $expediente->getStatus() == Expediente::STATUS_DELETED){
            throw new \Exception('No existe el expediente');
        }
        $usuario = $this->getUser();
        $estudio = $usuario->getEstudio();
        $em = $this->getDoctrine()->getManager();
        
        if($expediente->isUsuarioFavorito($usuario)){
            $repository = $this->getDoctrine()->getRepository('AppBundle:UsuarioExpediente');
            $expedienteFavorito  = $repository->findOneBy(Array(    "Expediente"=>$expediente, 
                                                                    "Estudio"=>$estudio, 
                                                                    "Usuario"=>$usuario));
            $em->remove($expedienteFavorito);        
        }else{
            $expedienteFavorito = new UsuarioExpediente();
            $expedienteFavorito->setEstudio($estudio)
                                ->setExpediente($expediente)
                                ->setUsuario($usuario);
            $em->persist($expedienteFavorito);
        }
        $em->flush();
        if($route!=""){
            return $this->redirect($route);
        }
        
        return $this->redirectToRoute('expediente_show', array('id'=>$expediente->getId()), 301);
    }
    
    
    /**
     * @Route("/showmenu" , name="expedientefavorito_showmenu")
     * @Template("ExpedienteBundle:ExpedienteFavorito:showmenu.html.twig")
     */
    public function showMenuAction()
    {
//        $em = $this->getDoctrine()->getManager();
//        $usuario = $this->getUser();
//        $estudio = $usuario->getEstudio();
//
//        $queryBuilder = $em->createQueryBuilder();
//        $queryBuilder
//            ->select('u')
//            ->from('CommonBundle:UsuarioExpediente','u')
//            ->innerJoin('u.Expediente', 'e')
//            ->where("e.status = 0 and u.Usuario =:usuario and u.Estudio = :estudio "
//                    . "and e.Estudio = :estudio")
//            ->setParameters(array("estudio"=>$estudio, "usuario"=>$usuario))
//            ->orderBy("u.fechaultimoingreso", "DESC")
//            ->setMaxResults(5);
//        $UsuarioExpedientes = $queryBuilder->getQuery()->getResult();
//        $cant = 0;
//        $cant = $em->createQuery('SELECT COUNT(e.id) '
//                                         . 'FROM CommonBundle:UsuarioExpediente e '
//                                         . 'WHERE e.Usuario = :usuario and e.Estudio = :estudio')
//                         ->setParameters(array('usuario'=>$usuario, 'estudio'=>$estudio))
//                         ->getSingleScalarResult();
//        if(!$cant){
//            $cant = 0;
//        }
//        return array("cant"=>$cant,"favoritos" => $UsuarioExpedientes);
        
    }
}
    