<?php

namespace Keboola\DockerDemo;

class SplitterTest extends \PHPUnit_Framework_TestCase
{

    public function testSetRowNumberColumn()
    {
        $splitter = new Splitter();
        $splitter->setRowNumberColumn("index");
        $this->assertEquals("index", $splitter->getRowNumberColumn());
    }

    public function testGetDefaultRowNumberColumn()
    {
        $splitter = new Splitter();
        $this->assertEquals("row_number", $splitter->getRowNumberColumn());
    }

    public function testProcess()
    {
        $sourceFile = sys_get_temp_dir() . "/" . uniqid("in");
        $outputFile = sys_get_temp_dir() . "/" . uniqid("out");

        $sourceFileContent = <<< EOF
id,text,some_other_column
1,"Short text","Whatever"
2,"Long text Long text Long text","Something else"

EOF;

        file_put_contents($sourceFile, $sourceFileContent);

        $splitter = new Splitter();
        $result = $splitter->processFile($sourceFile, $outputFile, "id", "text", 15);

        $expected = <<< EOF2
id,text,row_number
1,"Short text",0
2,"Long text Long ",0
2,"text Long text",1

EOF2;

        $this->assertStringEqualsFile($outputFile, $expected);
        $this->assertEquals(2, $result);
    }
}
