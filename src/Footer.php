<?php
namespace Unconv\CustomCms;

class Footer
{
    public function __construct(
        private string $heading,
        private string $text,
        private string $address,
        private string $phone,
        private string $email,
        private array $links,
        private string $copyright,
        private ?Form $form = null,
    ) {}

    public function get_heading(): string {
        return $this->heading;
    }

    public function get_text(): string {
        return $this->text;
    }

    public function get_address(): string {
        return nl2br( $this->address );
    }

    public function get_phone(): string {
        return $this->phone;
    }

    public function get_email(): string {
        return $this->email;
    }

    public function get_copyright(): string {
        return $this->copyright;
    }

    /**
     * Get footer links
     * @return FooterLink[]
     */
    public function get_links(): array {
        return $this->links;
    }

    public function get_form(): Form {
        return $this->form;
    }

    public function render(): string {
        $template = file_get_contents( __DIR__ . "/../templates/".$this->get_theme()."/elements/footer.html" );

        $links = $this->render_links();

        $form = "";
        if( isset( $this->form ) ) {
            $form = $this->get_form()->render();
        }

        $template = str_replace( [
            "{HEADING}",
            "{TEXT}",
            "{ADDRESS}",
            "{PHONE}",
            "{EMAIL}",
            "{LINKS}",
            "{COPYRIGHT}",
            "{FORM}",
        ], [
            $this->get_heading(),
            $this->get_text(),
            $this->get_address(),
            $this->get_phone(),
            $this->get_email(),
            $links,
            $this->get_copyright(),
            $form,
        ], $template );

        return $template;
    }

    private function render_links(): string {
        $links = $this->get_links();

        $rendered = "";

        foreach( $links as $link ) {
            $rendered .= $link->render();
        }

        return $rendered;
    }

    private function get_theme(): string {
        return "solid-state";
    }
}
