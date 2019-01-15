<?php declare(strict_types=1);

namespace TomasFejfar\Blog;

use Nette\Utils\DateTime;
use Symplify\Statie\Contract\Templating\FilterProviderInterface;

final class CustomFilterProvider implements FilterProviderInterface
{
    /**
     * @return callable[]
     */
    public function provide(): array
    {
        // jekyll-based - add to Statie
        return [
            // https://www.rubydoc.info/github/mojombo/jekyll/Jekyll%2FFilters:date_to_xmlschema
            // https://stackoverflow.com/a/26094939/1348344
            'date_to_xmlschema'=> function ($value) {
                return (new DateTime($value))->format('c');
            },

            'to_xmlschema'=> function ($value) {
                var_dump($value);
            }
        ];
    }
}
