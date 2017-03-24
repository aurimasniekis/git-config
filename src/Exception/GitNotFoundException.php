<?php

namespace AurimasNiekis\GitConfig\Exception;

use Exception;
use Throwable;

/**
 * Class GitNotFoundException
 *
 * @package AurimasNiekis\GitConfig\Exception
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class GitNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct(
            sprintf(
                'Git executable not found in "%s"',
                getenv('PATH')
            )
        );
    }

}