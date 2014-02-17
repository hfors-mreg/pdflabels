<?php
/**
 * This file is part of pdflabels.
 *
 * Copyright (c) 2014 Hannes Forsgård
 *
 * pdflabels is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * pdflabels is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with pdflabels.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace ledgr\pdflabels;

class LabelsTest extends \PHPUnit_Framework_TestCase
{
    public function testGetOrientation()
    {
        $landscape = new Labels(
            array(
                'page' => array(
                    'size' => array(
                        'height' => 100,
                        'width' => 200
                    )
                )
            )
        );
        $this->assertEquals('L', $landscape->getOrientation());

        $portrait = new Labels(
            array(
                'page' => array(
                    'size' => array(
                        'height' => 200,
                        'width' => 100
                    )
                )
            )
        );
        $this->assertEquals('P', $portrait->getOrientation());
    }

    public function testGetCell()
    {
        $labels = new Labels;
        $labels->addCell('foobar');
        $this->assertEquals('foobar', $labels->getCell(0));
        $this->assertEquals('', $labels->getCell(1));
    }

    public function testGetNrOfLinesInLabel()
    {
        $labels = new Labels;
        $this->assertEquals(1, $labels->getNrOfLinesInLabel());
        $labels->addCell("Line1\nLine2\nLine3");
        $this->assertEquals(3, $labels->getNrOfLinesInLabel());
    }

    public function testGetLineHeight()
    {
        $labels = new Labels(array('cell' => array('size' => array('height' => 100))));
        $this->assertEquals(100, $labels->getLineHeight());
        $labels->addCell("Line1\nLine2");
        $this->assertEquals(50, $labels->getLineHeight());
    }

    public function testGetLineHeightFromPreset()
    {
        $labels = new Labels(array('lineHeight' => 1000));
        $this->assertEquals(1000, $labels->getLineHeight());
    }

    public function testGetNrOfCols()
    {
        $labels = new Labels(
            array(
                'page' => array('size' => array('width' => 200)),
                'cell' => array('size' => array('width' => 50))
            )
        );
        $this->assertEquals(4, $labels->getNrOfCols());
    }

    public function testGetNrOfRows()
    {
        $labels = new Labels(
            array(
                'page' => array('size' => array('width' => 100)),
                'cell' => array('size' => array('width' => 50))
            )
        );
        $this->assertEquals(0, $labels->getNrOfRows());
        $labels->addCell('');
        $labels->addCell('');
        $labels->addCell('');
        $this->assertEquals(2, $labels->getNrOfRows());
    }

    public function testGetNrOfRowsPerPage()
    {
        $labels = new Labels(
            array(
                'page' => array('size' => array('height' => 200)),
                'cell' => array('size' => array('height' => 50))
            )
        );
        $this->assertEquals(4, $labels->getNrOfRowsPerPage());
    }

    public function testGetNrOfCellsPerPage()
    {
        $labels = new Labels(
            array(
                'page' => array(
                    'size' => array(
                        'height' => 200,
                        'width' => 200
                    )
                ),
                'cell' => array(
                    'size' => array(
                        'height' => 50,
                        'width' => 50
                    )
                )
            )
        );
        $this->assertEquals(16, $labels->getNrOfCellsPerPage());        
    }

    public function testGetGrid()
    {
        $labels = new Labels(
            array(
                'page' => array(
                    'size' => array(
                        'height' => 10,
                        'width' => 10
                    )
                ),
                'cell' => array(
                    'size' => array(
                        'height' => 10,
                        'width' => 10
                    )
                )
            )
        );

        $labels->addCell('foo');
        $labels->addCell('bar');

        $expected = array(
            array(
                array(
                    'x' => 0,
                    'y' => 0,
                    'content' => 'foo'
                )
            ),
            array(
                array(
                    'x' => 0,
                    'y' => 0,
                    'content' => 'bar'
                )
            )
        );

        $this->assertEquals($expected, $labels->getGrid());
    }

    public function testGetPdfNoException()
    {
        $labels = new Labels;
        $this->assertTrue(!!$labels->getPdf());
    }
}
