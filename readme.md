# Unihan 数据表生成

## 原始数据
Unihan提供的数据整理为csv表格。

数据来源：http://www.unicode.org/Public/UNIDATA/Unihan.zip
数据说明：https://www.unicode.org/reports/tr38/

## 使用说明
``` bash
make data.csv
```
或
``` bash
php trans.php > data.csv
```

data.csv 每行一个字，每列即一个属性。为防止打开csv时把部分数据解析为数字，数据前增加了一个冗余空格。
