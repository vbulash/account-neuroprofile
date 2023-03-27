<?php

if (!function_exists('createDropdown')) {
    function createDropdown(string $title, array $items) {
        $out = '';
        if (count($items) == 0)
            return '';
        if (count($items) == 1) {
            $item = $items[0];
            if (isset($item['click'])) {
                return sprintf(<<<'EOT'
<a href="javascript:void(0)" onclick="%s" class="btn btn-primary btn-sm float-left ms-1">
	<i class="%s"></i> %s
</a>
EOT, $item['click'], $item['icon'] ?? "fas fa-check", $item['title']);
            } else {
                return sprintf(<<<'EOT'
<a href="%s" class="btn btn-primary btn-sm float-left ms-1">
	<i class="%s"></i> %s
</a>
EOT, $item['link'], $item['icon'] ?? "fas fa-check", $item['title']);
            }
        } else {
            foreach ($items as $item) {
                if ($item['type'] == 'divider')
                    $out .= "<div class=\"dropdown-divider\"></div>\n";
                elseif (isset($item['click']))
                    $out .= sprintf("<li><a class=\"dropdown-item\" href=\"javascript:void(0)\" onclick=\"%s\"><i class=\"%s\"></i> %s</a></li>\n",
                        $item['click'], $item['icon'] ?? "fas fa-check", $item['title']);
                else
                    $out .= sprintf("<li><a class=\"dropdown-item\" href=\"%s\"><i class=\"%s\"></i> %s</a></li>\n",
                        $item['link'], $item['icon'] ?? "fas fa-check", $item['title']);
            }
            return sprintf(<<<'EOT'
<div class="dropdown">
	<button type="button" class="btn btn-primary dropdown-toggle show actions" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		%s
    </button>
	<div class="dropdown-menu" aria-labelledby="dropdown-dropup-primary" data-popper-placement="top-start">
		%s
	</div>
</div>
EOT, $title, $out);
        }
    }
}