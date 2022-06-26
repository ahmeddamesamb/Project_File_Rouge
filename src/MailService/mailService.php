<?php

namespace App\MailService;

use Twig\Environment;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class mailService{
    public function __construct(MailerInterface $mailler,Environment $environement){
      $this->mailler = $mailler;
      $this->environement=$environement;
    }


    
    public function envoiMail($data){
      $email= (new Email())
        ->from("MamadouMbelle@gmail.com")
        ->to($data->getEmail())
        ->subject("Creation compte")
        ->html($this->environement->render('vue/vue.html.twig',[
            'tab'=> $data->getPrenom(),
            'token'=>$data->getToken(),
        ]))       
           ;
        $this->mailler->send($email);
    }

}