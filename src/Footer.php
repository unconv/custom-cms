<?php
namespace Unconv\CustomCms;
use PDO;
use stdClass;

class Footer extends Element
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

    public function from_db( int $element_id, PDO $db ): static {
        $data = $this->get_data_from_db( $element_id, $db );

        return static::from_json( $data );
    }

    public static function from_json( stdClass $data ) {
        $form = Form::from_json( $data->form );
        $links = [];

        foreach( $data->links as $link ) {
            $links[] = FooterLink::from_json( $link );
        }

        return new static(
            heading: $data->heading,
            text: $data->text,
            address: $data->address,
            phone: $data->phone,
            email: $data->email,
            links: $links,
            copyright: $data->copyright,
            form: $form,
        );
    }

    public function get_array(): array {
        $links = [];

        foreach( $this->get_links() as $link ) {
            $links[] = $link->get_array();
        }

        return [
            "_type" => $this->get_element_type(),
            "heading" => $this->get_heading(),
            "text" => $this->get_text(),
            "address" => $this->address,
            "phone" => $this->get_phone(),
            "email" => $this->get_email(),
            "links" => $links,
            "copyright" => $this->get_copyright(),
            "form" => $this->get_form()->get_array(),
        ];
    }

    public function get_json(): string {
        return json_encode( $this->get_array() );
    }

    public function get_element_type(): ElementTypes {
        return ElementTypes::Footer;
    }
}
