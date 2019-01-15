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
            'date_to_xmlschema'=> function ($value): string {
                return DateTime::from($value)->format('c');
            },
            // https://www.rubydoc.info/github/mojombo/jekyll/Jekyll%2FFilters:xml_escape
            // https://3v4l.org/Mng53
            'xml_escape'=> function ($value): string {
                return htmlspecialchars($value);
            }
        ];
    }
}
