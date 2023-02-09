<?php
namespace Unconv\CustomCms;

require(__DIR__ . "/../vendor/autoload.php");

?>
<!DOCTYPE HTML>
<!--
	Solid State by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Solid State by HTML5 UP</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">

		<!-- Page Wrapper -->
			<div id="page-wrapper">

				<?php
                $header = new Header(
                    heading: "Something Else",
                    menu_name: "The Menu",
                );

                echo $header->render();

                $links = [
                    [
                        "url" => "index.html",
                        "text" => "Front page",
                    ],
                    [
                        "url" => "generic.html",
                        "text" => "Generic",
                    ],
                    [
                        "url" => "elements.html",
                        "text" => "Elements",
                    ]
                ];

                $menu = new Menu(
                    title: "The menu",
                    links: $links,
                    close_text: "Close",
                );

                echo $menu->render();

                $banner = new Banner(
                    heading: "This is cool!",
                    text: "This is a very cool website.",
                );

                echo $banner->render();
                ?>

				<!-- Wrapper -->
					<section id="wrapper">

                        <?php
                        $section = new Spotlight(
                            class: "style1",
                            image: "images/pic01.jpg",
                            title: "This is a title",
                            text: "This is some sample text",
                            link_url: "#",
                            link_text: "Click here now",
                        );

                        echo $section->render();

                        $section = new Spotlight(
                            class: "alt style2",
                            image: "images/pic01.jpg",
                            title: "This is a title 2",
                            text: "This is some sample text 2",
                            link_url: "#",
                            link_text: "Click here now",
                        );

                        echo $section->render();

                        $section = new Spotlight(
                            class: "style1",
                            image: "images/pic01.jpg",
                            title: "Third spotlight",
                            text: "Yay! Lorem ipsum dolor sit amet, etiam lorem adipiscing elit. Cras turpis ante, nullam sit amet turpis non, sollicitudin posuere urna. Mauris id tellus arcu. Nunc vehicula id nulla dignissim dapibus. Nullam ultrices, neque et faucibus viverra, ex nulla cursus.",
                            link_url: "#",
                            link_text: "Click here now",
                        );

                        echo $section->render();


                        $articles = [
                            new Article(
                                image: "images/pic03.jpg",
                                title: "Article title",
                                text: "Some text goes here",
                                link_url: "#",
                                link_text: "Click here",
                            ),
                            new Article(
                                image: "images/pic03.jpg",
                                title: "Article title",
                                text: "Some text goes here",
                                link_url: "#",
                                link_text: "Click here",
                            ),
                            new Article(
                                image: "images/pic03.jpg",
                                title: "Article title",
                                text: "Some text goes here",
                                link_url: "#",
                                link_text: "Click here",
                            ),
                            new Article(
                                image: "images/pic03.jpg",
                                title: "Article title",
                                text: "Some text goes here",
                                link_url: "#",
                                link_text: "Click here",
                            ),
                            new Article(
                                image: "images/pic03.jpg",
                                title: "Article title",
                                text: "Some text goes here",
                                link_url: "#",
                                link_text: "Click here",
                            ),
                        ];

                        $articleblock = new ArticleBlock(
                            title: "The articles",
                            text: "Here's some articles",
                            articles: $articles,
                            link_url: "#",
                            link_text: "Read more here",
                        );

                        echo $articleblock->render();
                        ?>

					</section>

                <?php
                $links = [
                    new FooterLink(
                        type: "facebook",
                        url: "https://facebook.com",
                        link_name: "Our Facebook Page",
                    ),
                    new FooterLink(
                        type: "twitter",
                        url: "https://twitter.com",
                        link_name: "Our Twitter Page",
                    ),
                ];

                $form = new Form(
                    action: "/",
                    submit_text: "Submit form",
                );

                $form->add_field( new FormField(
                    type: "text",
                    label: "Name",
                ) );

                $form->add_field( new FormField(
                    type: "text",
                    label: "Email",
                ) );

                $form->add_field( new FormField(
                    type: "textarea",
                    label: "Message",
                ) );

                $footer = new Footer(
                    heading: "Get in touch",
                    text: "You can get in touch by the for below",
                    address: "Address line 1\nAddress line 2",
                    phone: "1234567890",
                    email: "unconventionalcoding@gmail.com",
                    links: $links,
                    copyright: "My Company Ltd",
                    form: $form,
                );

                echo $footer->render();
                ?>
			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>