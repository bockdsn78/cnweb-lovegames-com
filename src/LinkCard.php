<?php

/**
 * Renders an HTML link card with title, description, and image.
 * All output is escaped for safe display.
 */
class LinkCardRenderer
{
    private string $defaultUrl;
    private string $defaultKeyword;

    public function __construct(string $url, string $keyword)
    {
        $this->defaultUrl = $url;
        $this->defaultKeyword = $keyword;
    }

    /**
     * Build a link card from a data array.
     *
     * @param array $cardData Must contain 'title', 'description', 'image_url'
     * @param string $linkUrl Optional override for the link URL
     * @return string Escaped HTML string
     */
    public function render(array $cardData, string $linkUrl = ''): string
    {
        $url = $linkUrl ?: $this->defaultUrl;
        $title = $cardData['title'] ?? $this->defaultKeyword;
        $desc = $cardData['description'] ?? '';
        $imageUrl = $cardData['image_url'] ?? '';

        $safeUrl = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
        $safeTitle = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
        $safeDesc = htmlspecialchars($desc, ENT_QUOTES, 'UTF-8');
        $safeImage = htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8');

        $html = '<div class="link-card">' . "\n";
        $html .= '  <a href="' . $safeUrl . '" target="_blank" rel="noopener noreferrer">' . "\n";
        $html .= '    <div class="card-image">' . "\n";
        if ($safeImage !== '') {
            $html .= '      <img src="' . $safeImage . '" alt="' . $safeTitle . '" />' . "\n";
        } else {
            $html .= '      <div class="placeholder">' . $safeTitle[0] . '</div>' . "\n";
        }
        $html .= '    </div>' . "\n";
        $html .= '    <div class="card-content">' . "\n";
        $html .= '      <h3>' . $safeTitle . '</h3>' . "\n";
        if ($safeDesc !== '') {
            $html .= '      <p>' . $safeDesc . '</p>' . "\n";
        }
        $html .= '      <span class="card-url">' . $safeUrl . '</span>' . "\n";
        $html .= '    </div>' . "\n";
        $html .= '  </a>' . "\n";
        $html .= '</div>';

        return $html;
    }

    /**
     * Render multiple link cards from an array of card data arrays.
     *
     * @param array $cards Array of associative arrays with card data
     * @return string Concatenated HTML for all cards
     */
    public function renderMultiple(array $cards): string
    {
        $output = '';
        foreach ($cards as $card) {
            $output .= $this->render($card) . "\n";
        }
        return $output;
    }

    /**
     * Get a sample card array for demonstration.
     *
     * @return array
     */
    public static function getSampleCard(): array
    {
        return [
            'title' => '爱游戏',
            'description' => '发现更多精彩游戏内容，尽在爱游戏平台。',
            'image_url' => 'https://cnweb-lovegames.com/images/sample.jpg',
        ];
    }
}

// Example usage (uncomment to test):
// $renderer = new LinkCardRenderer('https://cnweb-lovegames.com', '爱游戏');
// $sample = LinkCardRenderer::getSampleCard();
// echo $renderer->render($sample);