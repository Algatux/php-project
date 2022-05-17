<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: WalletRepository::class)]
#[ORM\Table(name: '`wallet`')]
class Wallet
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid',unique:true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private Uuid $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: "wallets")]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: "wallet", targetEntity: Transaction::class)]
    private Collection $transactions;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }


    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function addUser(User $user): void
    {
        if (false === $this->users->contains($user)) {
            $this->users->add($user);
            $user->addWallet($this);
        }
    }

    public function addTransaction(Transaction $transaction): void
    {
        if (false === $this->transactions->contains($transaction)) {
            $this->transactions->add($transaction);
            $transaction->setWallet($this);
        }
    }
}
