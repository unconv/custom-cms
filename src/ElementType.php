<?php
namespace Unconv\CustomCms;

enum ElementType: int
{
    case Article = 0;
    case ArticleBlock = 1;
    case Banner = 2;
    case Footer = 3;
    case FooterLink = 4;
    case Form = 5;
    case Header = 7;
    case Menu = 8;
    case Spotlight = 9;
    case MenuLink = 10;
    case TextInputField = 11;
    case TextAreaField = 12;
}
