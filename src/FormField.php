<?php
namespace Unconv\CustomCms;

class FormField extends Element
{
    public function __construct(
        protected string $label,
    ) {}

    public function get_label(): string {
        return $this->label;
    }
}
