<?php

namespace App\Entity;

use Datetime;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\MailController;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ApiResource(
  collectionOperations:[
    "get" =>[
        "status" => Response::HTTP_OK,
        "normalization_context" =>['groups' => ['user:read:simple']]
    ],
        "post",
        "validation"=>[
        "method"=>"patch",
        "deserialize"=>false,
        "path"=>"users/validate/{token}",
        "controller"=>MailController::class,
        "denormalization_context" =>['groups' => ['write']],
    ]
  ],
    itemOperations: [
        "put"=>[
            "security"=>"is_granted('ROLE_GESTIONAIRE')",
            "security_message"=>"Access denied in this ressource"
        ],
        "get" =>[
                "status" => Response::HTTP_OK,
                "normalization_context" =>['groups' => ['user:read:all']],
        ]
    ]
)]

#[ORM\Table(name: '`user`')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"role",type:"string")]
#[ORM\DiscriminatorMap(["client"=>"Client","livreur"=>"Livreur","gestionaire"=>"Gestionaire"])]
 class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["write"])]
    protected $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Groups(["write",'user:read:simple'])] 
    protected $email;
   
    #[ORM\Column(type: 'json')]
    protected $roles = [];

    #[ORM\Column(type: 'string')] 
    #[Groups(["write",'user:read:simple'])] 
    protected $password;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["write",'user:read:simple'])] 
    protected $prenom;

    #[ORM\Column(type: 'string', length: 255)]  
    #[Groups(["write",'user:read:simple'])] 
       protected $nom;

    #[ORM\Column(type: 'smallint',options:["default"=>1])]
    protected $etat;
    #[SerializedName("password")]
    protected $PlainPassword;

    #[ORM\Column(type: 'string', length: 255)]
    protected $token;
    #[ORM\Column(type: 'boolean')]
    protected $is_enable;

    #[ORM\Column(type: 'datetime')]
    protected $expireAt;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["write",'user:read:simple'])] 
    protected $telephone;

    public function tabRole(){
        $this->is_enable = false;
        $table= get_called_class();
        $table= explode('\\', $table);
        $table= strtoupper($table[2]);
        $this->roles[]='ROLE_'.$table;
        $this->etat=1;
    }
    public function token(){
      $this->token = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(random_bytes(16)));
    }

    public function __construct(){
        $this->expireAt = new \Datetime('+1 day');
        $this->tabRole();
        $this->token();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }
  
    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

       public function getPlainPassword(): ?string
    {
        return $this->PlainPassword;
    }

    public function setPlainPassword(string $PlainPassword): self
    {
        $this->PlainPassword = $PlainPassword;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }
    public function isIsEnable(): ?bool
    {
        return $this->is_enable;
    }

    public function setIsEnable(bool $is_enable): self
    {
        $this->is_enable = $is_enable;

        return $this;
    }

    public function getExpireAt(): ?\DateTimeInterface
    {
        return $this->expireAt;
    }

    public function setExpireAt(\DateTimeInterface $expireAt): self
    {
        $this->expireAt = $expireAt;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

}
