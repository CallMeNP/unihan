<?php

class Unicode
{

    private function checkSingleChar(string $char)
    {
        if (mb_strlen($char) !== 1) {
            throw new Exception("不是单个字符: $char");
        }
    }

    private function checkHexString(string $hex)
    {
        if (!ctype_xdigit($hex)) {
            throw new Exception("不是十六进制字符串: $hex");
        }
    }

    /**
     * 查询单个字符的unicode码（unicode code point）
     *
     * @param string $char 字符
     *
     * @return string 十六进制表示的unicode码
     * @throws Exception
     */
    public function charToUnicode(string $char): string
    {
        $this->checkSingleChar($char);
        return dechex(mb_ord($char));
    }

    /**
     * 查询单个字符的UTF-8编码值
     *
     * @param string $char 字符
     *
     * @return string 十六进制表示的UTF-8编码值
     * @throws Exception
     */
    public function charToUtf8(string $char): string
    {
        $this->checkSingleChar($char);
        return bin2hex($char);
    }

    /**
     * 将unicode码转换为字符
     *
     * @param string $hex 十六进制表示的unicode码
     *
     * @return string 字符
     * @throws Exception
     */
    public function unicodeToChar(string $hex): string
    {
        $this->checkHexString($hex);
        $char = mb_chr(hexdec($hex));
        if ($char === false) {
            throw new Exception('转换失败');
        }
        return $char;
    }

    /**
     * 将unicode码转换为UTF-8码
     *
     * @param string $hex 十六进制表示的unicode码
     *
     * @return string 十六进制表示的UTF-8编码值
     * @throws Exception
     */
    public function unicodeToUtf8(string $hex): string
    {
        return $this->charToUtf8($this->unicodeToChar($hex));
    }

    /**
     * 将UTF-8码转换为字符
     *
     * @param string $hex 十六进制表示的UTF-8编码值
     *
     * @return string
     * @throws Exception
     */
    public function utf8ToChar(string $hex): string
    {
        $this->checkHexString($hex);
        $char = pack('H*', $hex);
        if ($char === false) {
            throw new Exception('转换失败');
        }
        $this->checkSingleChar($char);
        return $char;
    }

    /**
     * 将UTF-8码转换为unicode码
     *
     * @param string $hex 十六进制表示的UTF-8编码值
     *
     * @return string 十六进制表示的unicode码
     * @throws Exception
     */
    public function utf8ToUnicode(string $hex): string
    {
        return $this->charToUnicode($this->utf8ToChar($hex));
    }

}

