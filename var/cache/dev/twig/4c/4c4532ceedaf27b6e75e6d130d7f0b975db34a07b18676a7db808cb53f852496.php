<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* default/index.html.twig */
class __TwigTemplate_64d35f86ac7a980c7242f3081e63d5ece66676c80927d60b2a50f9cf858deb70 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->blocks = [
            'main' => [$this, 'block_main'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "default/index.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "default/index.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "default/index.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 3
    public function block_main($context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "main"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "main"));

        // line 4
        echo "    <div id=\"colorlib-page\">
        <div id=\"colorlib-main\">
            <section class=\"ftco-section ftco-no-pt ftco-no-pb\">
                <div class=\"container\">
                    <div class=\"row d-flex\">
                        <div class=\"col-xl-8 py-5 px-md-5\">
                            <div class=\"row pt-md-4\">
                                <div class=\"col-md-12\">
                                    <div class=\"blog-entry ftco-animate d-md-flex fadeInUp ftco-animated\">
                                        <a href=\"#\" class=\"img img-2\" style=\"background-image: url(";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("images/image_1.jpg"), "html", null, true);
        echo ");\"></a>
                                        <div class=\"text text-2 pl-md-4\">
                                            <h3 class=\"mb-2\"><a href=\"#\">A Loving Heart is the Truest Wisdom</a></h3>
                                            <div class=\"meta-wrap\">
                                                <p class=\"meta\">
                                                    <span><i class=\"icon-calendar mr-2\"></i>June 28, 2019</span>
                                                    <span><a href=\"#\"><i class=\"icon-folder-o mr-2\"></i>Travel</a></span>
                                                    <span><i class=\"icon-comment2 mr-2\"></i>5 Comment</span>
                                                </p>
                                            </div>
                                            <p class=\"mb-4\">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                                            <p><a href=\"#\" class=\"btn-custom\">Read More <span class=\"ion-ios-arrow-forward\"></span></a></p>
                                        </div>
                                    </div>
                                </div>
                                <div class=\"col-md-12\">
                                    <div class=\"blog-entry ftco-animate d-md-flex fadeInUp ftco-animated\">
                                        <a href=\"#\" class=\"img img-2\" style=\"background-image: url(";
        // line 30
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("images/image_2.jpg"), "html", null, true);
        echo ");\"></a>
                                        <div class=\"text text-2 pl-md-4\">
                                            <h3 class=\"mb-2\"><a href=\"#\">Great Things Never Came from Comfort Zone</a></h3>
                                            <div class=\"meta-wrap\">
                                                <p class=\"meta\">
                                                    <span><i class=\"icon-calendar mr-2\"></i>June 28, 2019</span>
                                                    <span><a href=\"#\"><i class=\"icon-folder-o mr-2\"></i>Travel</a></span>
                                                    <span><i class=\"icon-comment2 mr-2\"></i>5 Comment</span>
                                                </p>
                                            </div>
                                            <p class=\"mb-4\">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                                            <p><a href=\"#\" class=\"btn-custom\">Read More <span class=\"ion-ios-arrow-forward\"></span></a></p>
                                        </div>
                                    </div>
                                </div>
                                <div class=\"col-md-12\">
                                    <div class=\"blog-entry ftco-animate d-md-flex fadeInUp ftco-animated\">
                                        <a href=\"#\" class=\"img img-2\" style=\"background-image: url(";
        // line 47
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("images/image_3.jpg"), "html", null, true);
        echo ");\"></a>
                                        <div class=\"text text-2 pl-md-4\">
                                            <h3 class=\"mb-2\"><a href=\"#\">Paths Are Made by Walking</a></h3>
                                            <div class=\"meta-wrap\">
                                                <p class=\"meta\">
                                                    <span>Dec 14, 2018</span>
                                                    <span><a href=\"#\">Lifestyle</a></span>
                                                    <span>5 Comment</span>
                                                </p>
                                            </div>
                                            <p class=\"mb-4\">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                                            <p><a href=\"#\" class=\"btn-custom\">Read More <span class=\"ion-ios-arrow-forward\"></span></a></p>
                                        </div>
                                    </div>
                                </div>
                                <div class=\"col-md-12\">
                                    <div class=\"blog-entry ftco-animate d-md-flex fadeInUp ftco-animated\">
                                        <a href=\"#\" class=\"img img-2\" style=\"background-image: url(";
        // line 64
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("images/image_4.jpg"), "html", null, true);
        echo ");\"></a>
                                        <div class=\"text text-2 pl-md-4\">
                                            <h3 class=\"mb-2\"><a href=\"#\">The Secret of Getting Ahead is Getting Started</a></h3>
                                            <div class=\"meta-wrap\">
                                                <p class=\"meta\">
                                                    <span>Dec 14, 2018</span>
                                                    <span><a href=\"#\">Nature</a></span>
                                                    <span>5 Comment</span>
                                                </p>
                                            </div>
                                            <p class=\"mb-4\">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                                            <p><a href=\"#\" class=\"btn-custom\">Read More <span class=\"ion-ios-arrow-forward\"></span></a></p>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- END-->
                        </div>
                    </div>
                </div>
            </section>
        </div><!-- END COLORLIB-MAIN -->
    </div>
    <!-- loader -->
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "default/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  131 => 64,  111 => 47,  91 => 30,  71 => 13,  60 => 4,  51 => 3,  29 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %}

{% block main %}
    <div id=\"colorlib-page\">
        <div id=\"colorlib-main\">
            <section class=\"ftco-section ftco-no-pt ftco-no-pb\">
                <div class=\"container\">
                    <div class=\"row d-flex\">
                        <div class=\"col-xl-8 py-5 px-md-5\">
                            <div class=\"row pt-md-4\">
                                <div class=\"col-md-12\">
                                    <div class=\"blog-entry ftco-animate d-md-flex fadeInUp ftco-animated\">
                                        <a href=\"#\" class=\"img img-2\" style=\"background-image: url({{ asset('images/image_1.jpg') }});\"></a>
                                        <div class=\"text text-2 pl-md-4\">
                                            <h3 class=\"mb-2\"><a href=\"#\">A Loving Heart is the Truest Wisdom</a></h3>
                                            <div class=\"meta-wrap\">
                                                <p class=\"meta\">
                                                    <span><i class=\"icon-calendar mr-2\"></i>June 28, 2019</span>
                                                    <span><a href=\"#\"><i class=\"icon-folder-o mr-2\"></i>Travel</a></span>
                                                    <span><i class=\"icon-comment2 mr-2\"></i>5 Comment</span>
                                                </p>
                                            </div>
                                            <p class=\"mb-4\">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                                            <p><a href=\"#\" class=\"btn-custom\">Read More <span class=\"ion-ios-arrow-forward\"></span></a></p>
                                        </div>
                                    </div>
                                </div>
                                <div class=\"col-md-12\">
                                    <div class=\"blog-entry ftco-animate d-md-flex fadeInUp ftco-animated\">
                                        <a href=\"#\" class=\"img img-2\" style=\"background-image: url({{ asset('images/image_2.jpg') }});\"></a>
                                        <div class=\"text text-2 pl-md-4\">
                                            <h3 class=\"mb-2\"><a href=\"#\">Great Things Never Came from Comfort Zone</a></h3>
                                            <div class=\"meta-wrap\">
                                                <p class=\"meta\">
                                                    <span><i class=\"icon-calendar mr-2\"></i>June 28, 2019</span>
                                                    <span><a href=\"#\"><i class=\"icon-folder-o mr-2\"></i>Travel</a></span>
                                                    <span><i class=\"icon-comment2 mr-2\"></i>5 Comment</span>
                                                </p>
                                            </div>
                                            <p class=\"mb-4\">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                                            <p><a href=\"#\" class=\"btn-custom\">Read More <span class=\"ion-ios-arrow-forward\"></span></a></p>
                                        </div>
                                    </div>
                                </div>
                                <div class=\"col-md-12\">
                                    <div class=\"blog-entry ftco-animate d-md-flex fadeInUp ftco-animated\">
                                        <a href=\"#\" class=\"img img-2\" style=\"background-image: url({{ asset('images/image_3.jpg') }});\"></a>
                                        <div class=\"text text-2 pl-md-4\">
                                            <h3 class=\"mb-2\"><a href=\"#\">Paths Are Made by Walking</a></h3>
                                            <div class=\"meta-wrap\">
                                                <p class=\"meta\">
                                                    <span>Dec 14, 2018</span>
                                                    <span><a href=\"#\">Lifestyle</a></span>
                                                    <span>5 Comment</span>
                                                </p>
                                            </div>
                                            <p class=\"mb-4\">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                                            <p><a href=\"#\" class=\"btn-custom\">Read More <span class=\"ion-ios-arrow-forward\"></span></a></p>
                                        </div>
                                    </div>
                                </div>
                                <div class=\"col-md-12\">
                                    <div class=\"blog-entry ftco-animate d-md-flex fadeInUp ftco-animated\">
                                        <a href=\"#\" class=\"img img-2\" style=\"background-image: url({{ asset('images/image_4.jpg') }});\"></a>
                                        <div class=\"text text-2 pl-md-4\">
                                            <h3 class=\"mb-2\"><a href=\"#\">The Secret of Getting Ahead is Getting Started</a></h3>
                                            <div class=\"meta-wrap\">
                                                <p class=\"meta\">
                                                    <span>Dec 14, 2018</span>
                                                    <span><a href=\"#\">Nature</a></span>
                                                    <span>5 Comment</span>
                                                </p>
                                            </div>
                                            <p class=\"mb-4\">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                                            <p><a href=\"#\" class=\"btn-custom\">Read More <span class=\"ion-ios-arrow-forward\"></span></a></p>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- END-->
                        </div>
                    </div>
                </div>
            </section>
        </div><!-- END COLORLIB-MAIN -->
    </div>
    <!-- loader -->
{% endblock %}", "default/index.html.twig", "/Users/pavelmilashki/Desktop/Wonderland/app/Resources/views/default/index.html.twig");
    }
}
