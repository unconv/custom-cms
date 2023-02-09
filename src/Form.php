<?php
namespace Unconv\CustomCms;

class Form
{
    protected array $fields = [];

    public function __construct(
        protected string $action,
        protected string $submit_text,
    ) {}

    public function add_field( FormField $field ) {
        $this->fields[] = $field;
    }

    public function render(): string {
        $rendered = '<form method="post" action="'.$this->action.'">
        <div class="fields">';

        foreach( $this->fields as $field ) {
            $rendered .= $field->render();
        }

        $rendered .= '
            </div>
            <ul class="actions">
                <li><input type="submit" value="'.$this->submit_text.'" /></li>
            </ul>
        </form>';

        return $rendered;
    }
}
