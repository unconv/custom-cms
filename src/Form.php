<?php
namespace Unconv\CustomCms;

class Form extends Element
{
    public function __construct(
        protected string $action,
        protected string $submit_text,
        protected array $fields = [],
    ) {}

    public function add_field( FormField $field ) {
        $this->fields[] = $field;
    }

    public function get_action(): string {
        return $this->action;
    }

    public function get_submit_text(): string {
        return $this->submit_text;
    }

    public function get_fields(): array {
        return $this->fields;
    }
}
