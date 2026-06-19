<?php

/**
 * Site meta information handler
 * 
 * Provides structured site metadata and description generation.
 */

class SiteMeta
{
    private array $metaData;
    
    public function __construct(array $config = [])
    {
        $defaults = [
            'name' => '爱游戏',
            'domain' => 'official-web-aiyouxi.com.cn',
            'description' => '爱游戏官方平台 - 提供优质游戏资讯与服务',
            'keywords' => ['爱游戏', '游戏', '娱乐', '资讯'],
            'language' => 'zh-CN',
            'charset' => 'UTF-8',
            'author' => '爱游戏团队',
            'version' => '1.3.0',
            'created' => '2024-01-15',
            'updated' => '2024-06-20'
        ];
        
        $this->metaData = array_merge($defaults, $config);
    }
    
    public function getMeta(string $key = null): mixed
    {
        if ($key === null) {
            return $this->metaData;
        }
        return $this->metaData[$key] ?? null;
    }
    
    public function generateShortDescription(int $maxLength = 150): string
    {
        $base = sprintf(
            '欢迎访问%s官方网站 %s。',
            $this->metaData['name'],
            $this->metaData['domain']
        );
        
        $extra = '我们致力于为玩家带来最新游戏动态、深度评测与独家福利。';
        
        $desc = $base . ' ' . $extra . ' ' . implode('、', $this->metaData['keywords']) . '。';
        
        if (mb_strlen($desc) > $maxLength) {
            $desc = mb_substr($desc, 0, $maxLength - 3) . '...';
        }
        
        return $desc;
    }
    
    public function renderMetaTags(): string
    {
        $charset = htmlspecialchars($this->metaData['charset'], ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($this->generateShortDescription(), ENT_QUOTES, 'UTF-8');
        $keywords = htmlspecialchars(implode(', ', $this->metaData['keywords']), ENT_QUOTES, 'UTF-8');
        $author = htmlspecialchars($this->metaData['author'], ENT_QUOTES, 'UTF-8');
        
        $tags = [];
        $tags[] = '<meta charset="' . $charset . '">';
        $tags[] = '<meta name="description" content="' . $description . '">';
        $tags[] = '<meta name="keywords" content="' . $keywords . '">';
        $tags[] = '<meta name="author" content="' . $author . '">';
        $tags[] = '<meta name="application-name" content="' . htmlspecialchars($this->metaData['name'], ENT_QUOTES, 'UTF-8') . '">';
        
        return implode("\n    ", $tags);
    }
}

// Example usage
$site = new SiteMeta();

$customSite = new SiteMeta([
    'name' => '爱游戏 - 游戏资讯平台',
    'domain' => 'official-web-aiyouxi.com.cn',
    'description' => '爱游戏官方平台 - 最新游戏资讯、评测与福利',
    'keywords' => ['爱游戏', '游戏资讯', '游戏评测', '福利活动'],
    'author' => '爱游戏内容团队'
]);

$description = $customSite->generateShortDescription();

$metaTags = $customSite->renderMetaTags();

$allMeta = $customSite->getMeta();

?>