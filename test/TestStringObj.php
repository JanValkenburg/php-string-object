<?php

require_once __DIR__ . '/../src/StringObj.php';
require_once __DIR__ . '/Tester.php';

class TestStringObj extends Tester
{

    public function run()
    {
        foreach ($this->methodList() as $method) {
            $this->$method();
        }
    }

    public function containsIsTrue() {
        $res = (new StringObj('foo'))
            ->contains('foo');

        $this->_isTrue($res);
    }
    public function containsIsFalse() {
        $res = (new StringObj('foo'))
            ->contains('joe');

        $this->_isFalse($res);
    }

    public function isEmptyIsTrue_01() {
        $res = (new StringObj(''))
            ->isEmpty();

        $this->_isTrue($res);
    }
    public function isEmptyIsTrue_02() {
        $res = (new StringObj(' '))
            ->isEmpty();

        $this->_isTrue($res);
    }
    public function isEmptyIsFalse() {
        $res = (new StringObj('a'))
            ->isEmpty();

        $this->_isFalse($res);
    }

    public function upperIsEqual() {
        $res = (new StringObj('foo'))
            ->upper();
        $this->_isEqual($res, 'FOO');
    }
    public function upperIsNotEqual() {
        $res = (new StringObj('foo'))
            ->upper();
        $this->_isNotEqual($res, 'foo');
    }

    public function isJapaneseIsTrue() {
        $res = (new StringObj('サッカー'))
            ->isJapanese();

        $this->_isTrue($res);
    }
    public function isJapaneseIsFalse() {
        $res = (new StringObj('открытая машина'))
            ->isJapanese();

        $this->_isFalse($res);
    }

    public function lengthIsEqual_01() {
        $res = (new StringObj(' Kippenhok in spee '))->wordCount();
        $this->_isEqual($res, 3);
    }
    public function lengthIsEqual_02() {
        $res = (new StringObj('Kippenhok in spee'))->wordCount();
        $this->_isEqual($res, 3);
    }
    public function lengthIsEqual_03() {
        $res = (new StringObj('サッカー'))->wordCount();
        $this->_isEqual($res, 1);
    }
    public function lengthIsEqual_04() {
        $res = (new StringObj('открытая машина'))->wordCount();
        $this->_isEqual($res, 2);
    }

    public function ucWordsIsEqual_01(){
        $res = (new StringObj('ELVIS "THE KING" PRESLEY - (LET ME BE YOUR) TEDDY BEAR'))->ucWords();
        $this->_isEqual($res, 'Elvis "The King" Presley - (Let Me Be Your) Teddy Bear');
    }

    public function replaceIsEqual_01() {
        $res = (new StringObj('ab'))->replace('a', 'b');
        $this->_isEqual($res, 'bb');
    }

    public function setIsEqual_01() {
        $res = (new StringObj('ab'))->set('foo');
        $this->_isEqual($res, 'foo');
    }

    public function lockSetIsEqual_01() {
        $res = (new StringObj('foo'))->lock()->set('joe');
        $this->_isEqual($res, 'foo');
    }

    public function matchIsTrue_01()
    {
        $res = (new StringObj('サッカー'))->match('サッカー');
        $this->_isTrue($res);
    }

    public function startsWith_01() {
        $res = (new StringObj('ab'))->startsWith('b');
        $this->_isFalse($res);
    }
    public function startsWith_02() {
        $res = (new StringObj('ab'))->startsWith('a');
        $this->_isTrue($res);
    }
    public function startsWith_03() {
        $res = (new StringObj('ab'))->startsWith('ab');
        $this->_isTrue($res);
    }
    public function startsWith_04() {
        $res = (new StringObj('ab'))->startsWith('ab');
        $this->_isTrue($res);
    }
    public function startsWith_05() {
        $res = (new StringObj('ab'))->startsWith('à');
        $this->_isFalse($res);
    }
    public function startsWith_06() {
        $res = (new StringObj('サッカー'))->startsWith('サ');
        $this->_isTrue($res);
    }

    public function endsWith_01() {
        $res = (new StringObj('ab'))->endsWith('A');
        $this->_isFalse($res);
    }
    public function endsWith_02() {
        $res = (new StringObj('ab'))->endsWith('ab');
        $this->_isTrue($res);
    }
    public function endsWith_03() {
        $res = (new StringObj('ab'))->endsWith('aB');
        $this->_isFalse($res);
    }
    public function endsWith_04() {
        $res = (new StringObj('ab'))->endsWith('');
        $this->_isFalse($res);
    }
    public function endsWith_05() {
        $res = (new StringObj('ab'))->endsWith(null);
        $this->_isFalse($res);
    }
    public function endsWith_06() {
        $res = (new StringObj('サッカー'))->endsWith('サ');
        $this->_isFalse($res);
    }
    public function endsWith_07() {
        $res = (new StringObj('サッカー'))->endsWith('ー');
        $this->_isTrue($res);
    }
}

(new TestStringObj)->run();
