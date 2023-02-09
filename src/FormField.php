<?php
namespace Unconv\CustomCms;

class FormField
{
    public function __construct(
        protected string $type,
        protected string $label,
    ) {}

    public function render(): string {
        $id = preg_replace( '/[^a-z_]/' , '', strtolower( $this->label ) );

        $rendered = '<div class="field">';

        $rendered .= '<label for="'.$id.'">'. htmlspecialchars( $this->label ) .'</label>';

        if( $this->type === "textarea" ) {
            $rendered .= '<textarea name="'.$id.'" id="'.$id.'" rows="4"></textarea>';
        } else {
            $rendered .= '<input type="text" name="'.$id.'" id="'.$id.'" />';
        }

        $rendered .= '</div>';

        return $rendered;
    }
}
