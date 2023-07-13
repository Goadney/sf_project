<?php

namespace App\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ArticleEntityTest extends KernelTestCase
{
    #les fonction commence toujours par test sinon pas detecté
    public function testFirstTest()
    {

        $result = 1 + 1;
        $this->assertEquals(2, $result);
    }
}
