<?php declare(strict_types=1);

namespace App\Entity;

use App\Enum\TransferType;
use App\Model\Formatter\Date as DateFormatter;
use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ORM\Table(name: '`transaction`')]
class Transaction implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique:true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private Uuid $id;

    #[ORM\Column(type: 'string', enumType: TransferType::class)]
    private TransferType $type;

    #[ORM\Column(type: 'text')]
    private string $motivation;

    #[ORM\Column(type: 'decimal', scale: 2)]
    private float $amount;

    #[ORM\ManyToOne(targetEntity: Wallet::class, inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Wallet $wallet;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "transactions")]
    private User $user;

    #[ORM\Column(
        type: 'datetime_immutable',
        columnDefinition: 'timestamp default current_timestamp not null'
    )]
    private \DateTimeInterface $timestamp;

    public function __construct()
    {
        $this->type = TransferType::OUT;
        $this->timestamp = new \DateTimeImmutable();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getType(): ?TransferType
    {
        return $this->type;
    }

    public function setType(TransferType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getMotivation(): string|null
    {
        return $this->motivation;
    }

    public function setMotivation(string $motivation): void
    {
        $this->motivation = $motivation;
    }

    public function getAmount(): float|null
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getTimestamp(): \DateTimeImmutable|\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeImmutable|\DateTimeInterface $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    public function getWallet(): ?Wallet
    {
        return $this->wallet;
    }

    public function setWallet(Wallet $wallet): void
    {
        $this->wallet = $wallet;
    }

    #[ArrayShape(['id' => "null|\Symfony\Component\Uid\Uuid", 'wallet_id' => "null|\Symfony\Component\Uid\Uuid", 'type' => "\App\Enum\TransferType|null", 'motivation' => "null|string", 'amount' => "float|null", 'user' => "null|\Symfony\Component\Uid\Uuid", 'timestamp' => "\App\Model\Formatter\Date"])]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'wallet_id' => $this->wallet->getId(),
            'type' => $this->getType(),
            'motivation' => $this->getMotivation(),
            'amount' => $this->getAmount(),
            'user' => $this->user->getId(),
            'timestamp' => new DateFormatter($this->getTimestamp())
        ];
    }
}
