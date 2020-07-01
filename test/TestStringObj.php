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
        $this->_isEqual($res, 4);
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
}

(new TestStringObj)->run();
