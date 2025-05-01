<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailService extends Mailable
{
    use Queueable, SerializesModels;
    public int $number_message;
    public $data;
    public $id_service;

    public function __construct($number_message, $data, $id_service)
    {
        $this->number_message = $number_message;
        $this->data = $data;
        $this->id_service = $id_service;
    }

    public function build()
    {

        $images = [
            // Desarrollo y Diseño
            [
                "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEj72Ga0skRjXoSA4lfHicy1rVJ0kd5DcCKq7Tj8LAhtap-6L4lrRsnoD85TRihXDx1OWE3BdIhRz1j5IJEidAzv1du5Ya5VQBLBAxuGEG9xuK6v4gjpP9jB3dA6otzZXV3j1vxXkdvrpto8i2l3HtzNjmaTWaeX_-Mb0G6jGCifbxBt5Jzyr_fEoZgL7xhQ/s16000/flyer-modal-1-1.jpg",
                "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEggZAozhvwXsX_KVF_unYAOXhUspbAuw03Gkouv51yzLaGHdmhzW-0nw63eD99WV7nywIIUBcy75xO2XCWG3KxosXfty7Kr0XUOpWeMXzNYaNhasB4j6sQQogbEsxvlfhrOXSgYmjv67ioEGowFeV2tl6-b568yNZVXvSaqHmZDcwpPb5bwm-MJPXoKvid7/s16000/flyer-modal-1-2.jpg",
                "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEhovmlEgV271V1uhTZBHYgNiPVC1wWYQimBUX4cCEs9ozmaVKOQPFT1ZDP5SUs-cnVgttagVS985vwePSAwRRJyFslHtwkY900Ll4aKpjh1wK40CYayhsBqJy4DI_Y1zI9INeQTXwGlfBDGXAlgvMaY-lMMtu5jcRZM2Q_Dcl-CCP8NtAQWuSRGNX2WRHlj/s16000/flyer-modal-1-3.jpg"
            ],
            // Gestión de Redes Sociales
            [
                "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiZTZrnY2A4K0McC6bFqIwChjlYcFsBVjaL-4gVzl87zajaE32egRRBKmIWQ4sfxu3j3MWpvNyXIfbyGpSjw9VS1rFwxMmqREpt0ka-uVimP5wF7o7143ir50K5_AKyJ5ZWvTXKg7_1kh61reKojmQiX6Lr2QkmM6r_1GFPXb2HRGFlYH-SSi5UUEfqOc5S/s16000/flyer-modal-2-1.jpg",
                "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEh_C0U0tfOZT92qeRr10AXjBfv2vytcekdRjiS_5lVJWii7PQ8Re6Pmi1sGX8K1FPyLO1KHS2txlW_2QP4AoCXWr6HEE6KEPLZriUVAubZnD-g4TS5PHDxXnOuBDyk06r5hEd0_koX0Wgaz5upF_fp1hAeRGwDkHCLP03dAM8Wf-01GhZ8Xp-KYFCrBuImA/s16000/flyer-modal-2-2.jpg",
                "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgPmzYChZBt2sCjeZTDtVRvTRmss3MS7nt8vbXMDcBZnUCz-fRfXThAla14Vvgg4My4qKQP8CPyj5hfbEMVXihUr931XQB1EsMvG1x81ifR4RE7hDuaYdfO5EfnsqkCrgglyXj4MlPaxyZpmvr8nZ9ZfYled6CqCzrp_tm2UJFL3p9pBbpzTugpMWEDOiSp/s16000/flyer-modal-2-3.jpg",
            ],
            // Marketing y Gestión Digital
            [
                "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEg092QZpO6nk2lCpzY4OoufMEqQ4t-4Cd6a2ZzPY1SKNRb40qJeU3dlHEdaFtnZTTZUbX1kbn3TXZ9Z4eVzgJTflVTsQBqZbd2yFnHUTHhtXGzLOm3G7AR5bQVVoGEU8dLJLxSBgLeuFv1YEzy-wtCy2QCUyAoSWRL4Ckc5a9b9XlJ62WmAU_zJG4z4e-Om/s16000/flyer-modal-3-1.jpg",
                "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjtreOOM1Y5NhyImyUSZ2VABJ7cJJz6ZIIV5wU87hCWEo35dY06KfKe6ouLUJpEGXscUfVwdTqom57OkynHHJc5EL0BzSmhnanSTTH6hbgrJRXVpqqQQ1t-QDFBN25m_4SzEeHZQUsdA5gaQlrZFic6yvsFu44lrXDr-8yHgG7qG21q0tEAgvg2a7yXrBDI/s16000/flyer-modal-3-2.jpg",
                "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgvG2owRjMlCU0lJuon4pDZhNj6-VsJIIDoHCFcTWyQAy7srnlkRxXJjoTB6eCQHXauDqLOeJ2VcJ6F6-5SiuoCBLcZvTpfPu3UQcg53yJmdKGaJqa-zJQTYptfztA1bpJgPzGNi_aP2BA2qpZ809flOkxkmA7rxZlE-jI87UhJtc8c2BQnUj_UeoSikvxj/s16000/flyer-modal-3-3.jpg",
            ],
            // Branding y Diseño
            [
                "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiq1Ug8AXStj8VhqjcBk_cptFzr5u1Ue_07ENc-nFqZvyHhuK0VJTxkF5VDs5A7fb5pTUrJFGw5t1WtkHPvXbxxIz5lOM6MUfb6a2XNVlmXpClZ-ujoblAL8tAQgfQyglAisTFmbRB4AVGBP3Mzde0wrNdZD93BjGoBdiP-4ZOlTnHDZ7LVhJqr-ehL73mo/s16000/flyer-modal-4-1.jpg",
                "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEh8p8zKOLYq9AULleN9EOvk9PybKHES_p7bpEuGrSEh90q7ubLAAVKYPjPtQF2aBMoSQK2V1MiO9tNV32jSViZfdkJDTRE9B1i5uND7NCj79Cnm8rRJ1xl5FSIED85E_D2I5gLUiX0mxosKJJdEUheiacMsjPXKEV8M8A7G8pT8plpPsCrfv4OkygHLLMNw/s16000/flyer-modal-4-2.jpg",
                "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgU0x4yrurrYawAgqDVER5cePp69tExxF5JtYRKNWxFXPaAcKdZE-bMoiIZtfMDhM97R9U4MPELvxub8iHeTulwSx2ClJpz4MKd6URFHl_Cz0I4QnfoF-3Is1ZR4nZz9YrTdEyAxO19F4rI6Ft9gtIPhKuBfHqnvwCcffQYCn_zItT_sbfB-y4_t1_ThQyK/s16000/flyer-modal-4-3.jpg",
            ]
        ];

        $title = [
            // Desarrollo y Diseño
            [
                "¡IMPULSA TU ÉXITO ONLINE CON DIGIMEDIA! 🌐",
                "¡FORTALECE TU PRESENCIA EN LÍNEA 💻!",
                "¡MAXIMIZA TU PRESENCIA ONLINE! 💻"
            ],
            // Gestión de Redes Sociales
            [
                "¡POTENCIA TU NEGOCIO DIGITAL CON DIGIMEDIA! 📈",
                "¡SUMÉRGETE EN EL MUNDO DIGITAL 📱!",
                "¡AUMENTA TU PRESENCIA EN LAS REDES Y CONQUISTA NUEVAS AUDIENCIAS CON NOSOTROS! 💻🚀 "
            ],
            // Marketing y Gestión Digital
            [
                "¡CRECE TU NEGOCIO CON DIGIMEDIA!📈",
                "¡INNOVA EN TUS ESTRATEGIAS DIGITALES!",
                "¡Aprovecha los beneficios del mundo digital! 👩🏻💻🖥 "
            ],
            // Branding y Diseño
            [
                "¡DESTACA TU NEGOCIO DIGITAL CON DIGIMEDIA! 🙌🏼",
                "¡MARCA LA DIFERENCIA! 😉",
                "¡TEN UNA IDENTIDAD ÚNICA! 😉"
            ]
        ];

        $subject = [
            // Desarrollo y Diseño

            [
                "IMPULSA TU ÉXITO ONLINE CON DIGIMEDIA! 🌐",
                "¡FORTALECE TU PRESENCIA EN LÍNEA 💻!",
                "¡MAXIMIZA TU PRESENCIA ONLINE! 💻"
            ],
            // Gestión de Redes Sociales
            [
                "POTENCIA TU NEGOCIO DIGITAL CON DIGIMEDIA 📈",
                "¡SUMÉRGETE EN EL MUNDO DIGITAL 📱!",
                "¡AUMENTA TU PRESENCIA EN LAS REDES Y CONQUISTA NUEVAS AUDIENCIAS CON NOSOTROS! 💻🚀 "
            ],
            // Marketing y Gestión Digital
            [
                "¡CRECE TU NEGOCIO CON DIGIMEDIA 📈!",
                "¡INNOVA EN TUS ESTRATEGIAS DIGITALES!",
                "¡Aprovecha los beneficios del Mundo Digital! 👩🏻💻🖥 * "
            ],
            // Branding y Diseño
            [
                "¡DESTACA TU NEGOCIO DIGITAL CON DIGIMEDIA! 🙌🏼",
                "¡MARCA LA DIFERENCIA! 😉",
                "¡TEN UNA IDENTIDAD ÚNICA! 😉"
            ]
        ];

        $message = [
            // Desarrollo y Diseño
            [
                "¿Estás cansado de enfrentar problemas con tu sitio web que afectan el crecimiento de tu negocio? En DigiMedia, no solo creamos sitios web, ¡Forjamos plataformas de impacto!📈.
                📌 Diseño impactante con resultados asombrosos
                📌Experiencia del usuario que deja huella.

                Estamos emocionados de ser tu socio en tu próximo éxito online.

                Si estás listo para un desarrollo web que marque la diferencia, te garantizamos el mejor servicio de diseño y desarrollo web para que puedas potenciarte en el mundo digital con nuestros beneficios exclusivos 🙌🏼:

                -📈 Aumento de visibilidad y tráfico web.
                -🌐 Sitios web altamente personalizados con herramientas seguras.",

                "¿Quieres tener las mejores estrategias online de marketing?

                En DigiMedia somos expertos dominando el mundo digital y juntos potenciaremos tu presencia online.  Con nuestros beneficios exclusivos 🙌🏼:
                - Desarrollo en identidad visual de tu marca.
                - Experiencia del usuario excepcional que convierte visitantes en clientes leales.

                ¡No te quedes atrás en la era digital y transforma tu marca con soluciones innovadoras! Contáctanos y que comience tu presencia digital.",

                "TRIPLIQUE TUS VENTAS impulsar tu éxito  digital con beneficios exclusivos:
                Aumento de visibilidad y tráfico web garantizado. Experiencia del usuario excepcional que convierte visitantes en clientes leales. ¡Construye una plataforma de impacto con nosotros y haz que tu negocio brille en la WEB!"
            ],
            // Gestión de Redes Sociales
            [

                "¿Tus redes sociales no generan interacciones? En DigiMedia, estamos comprometidos en potenciar tu presencia en línea a través de la gestión de redes sociales. Al confiarnos la administración de tus plataformas digitales, experimentarás un aumento significativo en la visibilidad y participación de tu marca. Nuestros beneficios:\n\n

                🚀 Potenciación de tu presencia digital.\n
                🚀 Contenido estratégico y de valor.\n\n

                Transformemos juntos tu presencia digital! ¡Háznoslo saber!",

                "¿Quieres tener contenido de calidad? Deja la gestión de tus redes sociales en manos expertas con DigiMedia y haz crecer tu negocio de la mejor manera con nuestros beneficios: \n\n

                - Planificación y organización de contenidos.\n
                - Análisis de resultados con informes mensuales.",

                "¿Buscas contenido de alto impacto? Confía en los especialistas de DigiMedia Marketing para gestionar tus redes sociales y lleva tu negocio al siguiente nivel con nuestro servicio de Gestión Redes Sociales.\n\n

                ✅ Diseño estratégico y calendario de contenido en redes.
                ✅ Análisis de desempeño con reportes mensuales y más!"
            ],

            [
                "En DigiMedia Marketing, estamos comprometidos en el mejor desarrollo en marketing digital. Tendremos el placer de armar estrategias que promuevan tu marca a través de diferentes entornos digitales. ¿Las estrategias que planteas no logran los objetivos de tu empresa?, entonces adquiere nuestro servicio con beneficios exclusivos: \n\n

                📌 Mejorar tu visibilidad online. \n
                📌 Vínculo de lealtad con los clientes. \n\n

                ¡No te quedes atrás en la era digital y transforma tu marca con soluciones innovadoras! Contacto y que comience tu presencia digital.",

                "¿Quieres tener las mejores estrategias online de marketing? En DigiMedia somos expertos dominando el mundo digital y juntos potenciaremos tu presencia digital. \n\n

                - Vínculo de lealtad con los clientes\n
                - Desarrollar publicidad en línea\n\n

                💻 Obtén mayores ganancias digitalizando tu negocio junto a DigiMedia Marketing 💰📈. Con el servicio de marketing y gestión digital podrás tener:\n\n

                ✅ Estrategias digitales personalizadas.\n
                ✅ Mejor rendimiento de tu presupuesto.\n\n

                Comunícate con nosotros/responde este mensaje para obtener más información y comienza a ver resultados.",

                "¿Quieres tener las mejores estrategias online de marketing? En DigiMedia somos expertos dominando el mundo digital y juntos potenciaremos tu presencia digital.\n\n

                - Vínculo de lealtad con los clientes\n
                - Desarrollar publicidad en línea\n\n

                💻 Obtén mayores ganancias digitalizando tu negocio junto a DigiMedia Marketing 💰📈. Con el servicio de marketing y gestión digital podrás tener:\n\n

                ✅ Estrategias digitales personalizadas.\n
                ✅ Mejor rendimiento de tu presupuesto.\n\n

                Comunícate con nosotros/responde este mensaje para obtener más información y comienza a ver resultados.",
            ],
            // Branding y Diseño
            [
                "¿Sientes que tu negocio no se diferencia del resto? ¡Haz que tu marca sea inolvidable!
                En DigiMedia, estamos preparados para llevar la identidad de tu marca a otro nivel. Somos especialistas en crear diseños irresistibles y branding cautivador.\n
                Adquiere nuestros beneficios exclusivos\n\n

                📌 Diferenciación y Reconocimiento\n

                Prepárate para darle un giro a tu negocio con todos nuestros beneficios ¡Contacte con nosotros!",

                "¿Quieres destacar entre tu competencia? Con DigiMedia podrás tener una marca sólida gracias a nuestro servicio de Branding y diseño que te ayudarán a ser reconocida entre tus clientes 🚀.\n\n

                - ✅ Desarrollo en identidad visual de tu marca\n
                - ✅ Originalidad en conceptos de marca ",

                "En DigiMedia garantizamos crear experiencias visuales impactantes y memorables para que puedas conectar con tu audiencia, nuestro servicio de Branding y diseño te ayudarán a lograr esto 🚀. Nuestros beneficios:\n\n
                - Originalidad en conceptos de marca\n
                - Construcción de confianza y credibilidad\n\n

                ¡Sé parte del mundo digital y potencia tu marca con nosotros! 🙌🏼"
            ]
        ];

        $message_send = $message[$this->id_service - 1][$this->number_message - 1];
        $image_send = $images[$this->id_service - 1][$this->number_message - 1];
        $title_send = $title[$this->id_service - 1][$this->number_message - 1];
        $subject_send = $subject[$this->id_service - 1][$this->number_message - 1];

        return $this->subject($subject_send)
                ->view('mails.modal')
                ->with([
                    'data' => $this->data,
                    'send_message' => $message_send,
                    'title' => $title_send,
                    'image' => $image_send,
                ]);
    }
}
