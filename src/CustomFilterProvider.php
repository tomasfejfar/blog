<?php declare(strict_types=1);

namespace TomasFejfar\Blog;

use Symplify\Statie\Contract\Templating\FilterProviderInterface;

final class CustomFilterProvider implements FilterProviderInterface
{
    /**
     * @return callable[]
     */
    public function provide(): array
    {
        // jekyll-based
        return [
            'date_to_xmlschema'=> function ($value) {
                var_dump($value);
            }
        ];
    }
}
