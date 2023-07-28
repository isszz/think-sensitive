
# think-sensitive
thinkphp6+ 敏感词检测，过滤

<p>
    <a href="https://packagist.org/packages/isszz/think-sensitive"><img src="https://img.shields.io/badge/php->=8.0-8892BF.svg" alt="Minimum PHP Version"></a>
    <a href="https://packagist.org/packages/isszz/think-sensitive"><img src="https://img.shields.io/badge/thinkphp->=6.x-8892BF.svg" alt="Minimum Thinkphp Version"></a>
    <a href="https://packagist.org/packages/isszz/think-sensitive"><img src="https://poser.pugx.org/isszz/think-sensitive/v/stable" alt="Stable Version"></a>
    <a href="https://packagist.org/packages/isszz/think-sensitive"><img src="https://poser.pugx.org/isszz/think-sensitive/downloads" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/isszz/think-sensitive"><img src="https://poser.pugx.org/isszz/think-sensitive/license" alt="License"></a>
</p>

## 安装

```shell
composer require isszz/think-sensitive
```

## 配置
```php
return [
    // 支持file，array
    'mode' => 'file', // file模式时，敏感词库位于tp根目录的config/sensitive/SensitiveWord.txt，也可以指向自定义的词库文件路径

    'config' => [
        'repeat' => true, // 重复替换为敏感词相同长度的字符
        'replaceChar' => '*', // 替换字符
        // 标记敏感词，标签生成<mark>敏感词</mark>
        'mark' => 'mark', 
    ],

    // 干扰因子
    'interference_factors' => [
        ' ', '&', '*', '/', '|', '@', '.', '^', '~', '$',
    ],

    // 数组模式敏感词
    'sensitive_words' => [
        '工口',
        '里番',
        '性感美女',
    ]
];

```

## 使用

facade方式
```php
use isszz\sensitive\facade\Sensitive;

class Index
{
    public function add()
    {
        // 设置干扰因子
        Sensitive::interferenceFactor(['(', ')', ',', '，', ';', '；', '。']);

        // 添加一个额外的敏感词，words参数支持单敏感词，多词也可以用|分割，或者直接传入多个敏感词数组
        // words = 性感美女|分隔符
        // words = ['性感美女', '数组']
        Sensitive::add(words: '性感美女');

        // 删除的敏感词，words参数同添加的格式一样
        // 第二个参数once为true时，只针对当次: check，replace，mark，操作生效
        Sensitive::remove(words: '性感美女', once: true);
        // 替换
        $replaced = Sensitive::add(words: '垃圾')->replace(content: '替换语句垃圾要被替换', replaceChar: '*', repeat: false);

        // 标记敏感词
        $marked = Sensitive::add(words: '尼玛')->mark(content: '标记的内容，这里尼玛要被标记', tag: 'bad');

        // 提取内容中的所有敏感词
        $badWords = $sensitive->add('狗逼')->getBadWord('提取内容中的所有敏感词，狗逼，还有SB都会被提取');

        // 检测
        if (Sensitive::check(content: '检测语句')) {
            return json(['code' => 1, 'msg' => '输入内容包含敏感词，请注意用词。']);
        }

        // 自定义敏感词库
        // 敏感词文件
        Sensitive::custom('SensitiveWord.txt');
        // 数组方式
        Sensitive::custom([
            '垃圾', '尼玛', 
            //...
        ])->check('检测尼玛的语句');

        // 添加新敏感词到词库文件
        // append参数为true是追加模式，false时先提取词库，再去重然后合并写入
        $sensitive->addWordToFile(data: '狗逼|傻缺', append: false);
    }
}

```
依赖注入方式
```php
class Index
{
    public function add(\isszz\sensitive\Sensitive $sensitive)
    {
        // 设置干扰因子
        $sensitive->interferenceFactor(['(', ')', ',', '，', ';', '；', '。']);
        // ...
    }
}
```
