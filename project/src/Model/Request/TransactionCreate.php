<?php declare(strict_types=1);

namespace App\Model\Request;

use Symfony\Component\Validator\Constraints as Assert;

class TransactionCreate implements MappableRequestInterface
{
    #[Assert\Uuid]
    #[Assert\NotBlank(allowNull: false)]
    #[Assert\Type('string')]
    public mixed $user;

    #[Assert\Uuid]
    #[Assert\NotBlank(allowNull: false)]
    #[Assert\Type('string')]
    public mixed $wallet;

    #[Assert\NotBlank(allowNull: false)]
    #[Assert\Type('float')]
    public mixed $amount;

    #[Assert\NotBlank(allowNull: false)]
    #[Assert\Type('string')]
    public mixed $motivation;
}
