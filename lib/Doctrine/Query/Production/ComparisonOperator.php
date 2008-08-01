<?php
/*
 *  $Id$
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://www.phpdoctrine.org>.
 */

/**
 * ComparisonOperator = "=" | "<" | "<=" | "<>" | ">" | ">=" | "!="
 *
 * @package     Doctrine
 * @subpackage  Query
 * @author      Janne Vanhala <jpvanhal@cc.hut.fi>
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link        http://www.phpdoctrine.org
 * @since       2.0
 * @version     $Revision$
 */
class Doctrine_Query_Production_ComparisonOperator extends Doctrine_Query_Production
{
    public function syntax($paramHolder)
    {
        switch ($this->_parser->lookahead['value']) {
            case '=':
                $this->_parser->match('=');
                return '=';
            break;

            case '<':
                $this->_parser->match('<');
                $operator = '<';

                if ($this->_isNextToken('=')) {
                    $this->_parser->match('=');
                    $operator .= '=';
                } elseif ($this->_isNextToken('>')) {
                    $this->_parser->match('>');
                    $operator .= '>';
                }

                return $operator;
            break;

            case '>':
                $this->_parser->match('>');
                $operator = '>';

                if ($this->_isNextToken('=')) {
                    $this->_parser->match('=');
                    $operator .= '=';
                }

                return $operator;
            break;

            case '!':
                $this->_parser->match('!');
                $this->_parser->match('=');
                return '<>';
            break;

            default:
                $this->_parser->syntaxError('=, <, <=, <>, >, >=, !=');
            break;
        }
    }
    
    /**
     * Visitor support.
     *
     * @param object $visitor
     */
    public function accept($visitor)
    {
        $visitor->visitComparisonOperator($this);
    }
}