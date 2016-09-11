<?php

namespace Concrete\Core\Updater\Migrations\Migrations;

use Concrete\Core\Page\Stack\StackList;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20150616000000 extends AbstractMigration
{

    public function up(Schema $schema)
    {
        \Concrete\Core\Database\Schema\Schema::refreshCoreXMLSchema(array(
            'Stacks',
        ));

        if (\Core::make('multilingual/detector')->isEnabled()) {
            StackList::rescanMultilingualStacks();
        }
    }

    public function down(Schema $schema)
    {

    }


}
