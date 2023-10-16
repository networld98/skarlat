<?
define("HIDE_SIDEBAR", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle(GetMessage("CONTACTS"));
?>
<!-- SECTION CONTACT CONTANT START -->
<div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-12 mb-5">
                <div class="map">
                    <iframe
                        allowfullscreen=""
                        height="500"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d162757.72582758658!2d30.392608824595417!3d50.40217023835585!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40d4cf4ee15a4505%3A0x764931d2170146fe!2z0JrQuNC10LIsIDAyMDAw!5e0!3m2!1sru!2sua!4v1574669525773!5m2!1sru!2sua"
                        style="border:0; width:100%"
                    ></iframe>
                </div>
            </div>

            <div class="col-lg-4 col-12 mb-5">
                <table class="table table-borderless">
                    <tbody>
                    <tr>
                        <th scope="row">
                            <svg class="p-1" style="max-width:25px; min-width:20px" viewbox="0 0 10 10">
                                <path
                                    d="M9.8 7.9L8.2 6.4c-.3-.3-.8-.3-1.1 0l-.8.8s-.1-.1-.2-.1c-.4-.3-1.1-.7-1.8-1.4S3.2 4.3 2.9 3.8c0-.1-.1-.1-.1-.2l.5-.5.3-.3c.4-.2.4-.7.1-1L2.1.2c-.3-.3-.8-.3-1.1 0L.5.7l-.3.6c-.1.3-.1.5-.2.7-.2 1.7.6 3.2 2.7 5.3C5.6 10.2 7.9 10 8 10c.2 0 .4-.1.6-.2.2-.1.4-.2.6-.4l.6-.4c.3-.3.3-.8 0-1.1z"
                                ></path>
                            </svg>
                        </th>
                        <td><span style="font-weight:500"><?=GetMessage("PHONE")?></span></td>
                        <td>
                            <a href="tel:0443336965" style="color: rgb(238, 56, 64); font-size:14px">+38 (044) 333 92 96</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <svg class="p-1" style="max-width:25px; min-width:20px" viewbox="0 0 10 10">
                                <path
                                    d="M9.8 7.9L8.2 6.4c-.3-.3-.8-.3-1.1 0l-.8.8s-.1-.1-.2-.1c-.4-.3-1.1-.7-1.8-1.4S3.2 4.3 2.9 3.8c0-.1-.1-.1-.1-.2l.5-.5.3-.3c.4-.2.4-.7.1-1L2.1.2c-.3-.3-.8-.3-1.1 0L.5.7l-.3.6c-.1.3-.1.5-.2.7-.2 1.7.6 3.2 2.7 5.3C5.6 10.2 7.9 10 8 10c.2 0 .4-.1.6-.2.2-.1.4-.2.6-.4l.6-.4c.3-.3.3-.8 0-1.1z"
                                ></path>
                            </svg>
                        </th>
                        <td><span style="font-weight:500"><?=GetMessage("PHONE")?></span></td>
                        <td>
                            <a href="tel:0679387248" style="color: rgb(238, 56, 64); font-size:14px">+38 (067) 938 72 48</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <svg class="p-1" style="max-width:25px; min-width:20px" viewbox="0 0 10 10">
                                <path
                                    d="M10 2.3c0-.3-.2-.6-.5-.6h-9c-.1 0-.3.1-.4.2 0 .1-.1.2-.1.4v5c0 .1.1.3.2.4.1.1.2.1.4.1h9c.3 0 .5-.2.5-.5l-.1-5zm-1.1 0L5 5 1.1 2.3h7.8zM6.7 5.5L9 7.3H1l2.3-1.8c.1-.1.1-.2 0-.4 0-.1-.2-.1-.3 0L.5 7V2.5l4.3 3H5l4.3-3v4.6L7 5.1c-.1-.1-.3-.1-.4 0-.1.1-.1.3.1.4z"
                                ></path>
                            </svg>
                        </th>
                        <td><span style="font-weight:500">Email:</span></td>
                        <td>
                            <a href="mailto:shop@skarlat.ua" style="color: rgb(238, 56, 64); font-size:14px"
                            >shop@skarlat.ua</a
                            >
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <svg class="p-1" style="max-width:25px; min-width:20px" viewbox="0 0 10 10">
                                <path
                                    d="M5.5 10.2V5.6h1.3L7 3.7H5.5V2.4c0-.5.3-.7.6-.7H7V.1C6.9 0 6.7 0 6.6 0h-.8c-.4 0-.8.1-1.1.4-.4.4-.6.8-.7 1.4V3.7H2.7v1.8H4v4.6h1.5z"
                                ></path>
                            </svg>
                        </th>
                        <td><span style="font-weight:500">Facebook</span></td>
                        <td>
                            <a
                                href="https://www.facebook.com/skarlat.ua/"
                                style="color: rgb(238, 56, 64);font-size:14px"
                                target="blank"
                            >@skarlat.ua</a
                            >
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <svg class="p-1" style="max-width:25px; min-width:20px" viewbox="0 0 10 10">
                                <path
                                    d="M6.8 10H3c-1.7 0-3-1.4-3-3V3.2c0-1.7 1.4-3 3-3h3.8c1.7 0 3 1.4 3 3V7c.1 1.6-1.3 3-3 3zm1.5-7.7c0 .4-.3.6-.6.6-.4 0-.7-.2-.7-.6s.3-.7.7-.7c.4 0 .6.3.6.7zM4.9 7.6c-1.4 0-2.5-1.1-2.5-2.5s1.1-2.5 2.5-2.5 2.5 1.1 2.5 2.5-1.1 2.5-2.5 2.5zm0-4.3c-1 0-1.7.8-1.7 1.7S4 6.8 4.9 6.8 6.7 6 6.7 5.1s-.8-1.8-1.8-1.8zM3 .9C1.7.9.7 1.9.7 3.2V7c0 1.3 1 2.3 2.3 2.3h3.8c1.3 0 2.3-1 2.3-2.3V3.2c0-1.3-1-2.3-2.3-2.3H3z"
                                ></path>
                            </svg>
                        </th>
                        <td><span style="font-weight:500">Instagram</span></td>
                        <td>
                            <a
                                href="https://www.instagram.com/skarlat.ua/"
                                style="color: rgb(238, 56, 64);font-size:14px"
                                target="blank"
                            >@skarlat.ua</a
                            >
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <svg class="p-1" style="max-width:25px; min-width:20px" viewbox="0 0 10 10">
                                <path
                                    d="M3.9 6.3l-.1 2.4c.2 0 .3-.1.5-.2l1.1-1.1 2.3 1.7c.4.2.7.1.8-.4L10 1.6c.1-.6-.3-.9-.7-.7L.5 4.3c-.6.2-.6.6-.1.7l2.3.7L8 2.4c.2-.2.5-.1.3.1L3.9 6.3z"
                                ></path>
                            </svg>
                        </th>
                        <td><span style="font-weight:500">Telegram</span></td>
                        <td>
                            <a
                                href="tg://resolve?domain=SkarlatStore"
                                style="color: rgb(238, 56, 64);font-size:14px"
                                target="blank"
                            >@Skarlat Store</a
                            >
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <svg
                                class="p-1"
                                style="max-width:25px; min-width:20px"
                                text-rendering="geometricPrecision"
                                viewbox="0 0 10 10"
                            >
                                <path
                                    d="M9.5 2.4C9.3 1.5 8.3.5 7.3.3 5.8 0 4.2 0 2.7.3 1.8.5.7 1.5.5 2.4.2 3.7.2 5 .5 6.3c.2.9 1.2 1.9 2.1 2.1v1c0 .4.4.6.7.3l1-1.1H5c.8 0 1.5-.1 2.3-.2.9-.2 2-1.2 2.2-2.1.3-1.2.3-2.6 0-3.9zM6 4.2zm0 0zm0 0c-.1 0-.1-.1-.1-.1v-.2c0-.1-.1-.2-.2-.3l-.1-.1h-.2c-.1 0-.1-.1-.1-.2s.1-.1.1-.1c.4 0 .8.3.8.8v.1c-.1.1-.1.1-.2.1zM5 1.9zm.5.1zm0 0zm0 0zm-.4-.1zm-.1 0zm0 0zm.1 0h.1-.1zm.4.1zm0 0zm0 0zm0 0zm0 0zm0 0zm0 0H5.2c1.1 0 2.1.8 2.3 1.9 0 .2 0 .4.1.6 0 .1 0 .2-.1.2s-.1-.1-.1-.2V4c-.5-.9-1.1-1.6-2-1.7H5c-.1 0-.2 0-.2-.1s.1-.2.1-.2h.6zM5 1.9zm1 2.3zm.7 0s0 .1 0 0c0 .2-.2.2-.3.1v-.1c0-.2-.1-.5-.2-.7 0-.2-.2-.4-.4-.5-.2-.1-.3-.1-.5-.1h-.2c0-.1-.1-.1-.1-.2s.1-.1.1-.1c.3 0 .5.1.7.2.6.2.9.6.9 1.2v.2zm0 0zM5 1.9zm0 0zm0 0zM6.4 7c-.1 0-.2 0-.3-.1-.9-.4-1.7-.9-2.3-1.6-.4-.4-.7-.9-.9-1.4-.1-.2-.2-.4-.3-.7-.1-.2 0-.4.2-.6.1-.2.3-.3.5-.4.1-.1.3 0 .4.1.2.3.4.5.6.8.1.2.1.4-.1.5l-.1.1-.1.1c0 .1-.1.2 0 .2.2.6.6 1.1 1.2 1.4.1 0 .2.1.3.1.2 0 .3-.2.4-.4.1-.1.3-.1.4 0 .1.1.3.2.4.3.1.1.3.2.4.3.1.3.1.4.1.6-.2.2-.3.4-.6.6-.1 0-.2 0-.2.1zm0 0zm2.3-.8c-.2.6-.9 1.3-1.6 1.5-.8.1-1.6.2-2.4.2-.2.1-.8.8-.8.8l-.8.8c-.1.1-.2 0-.2 0V7.7v-.1c-.6-.1-1.4-.8-1.6-1.4-.2-1.2-.2-2.4 0-3.6.2-.6 1-1.3 1.6-1.5 1.4-.3 2.8-.3 4.3 0 .6.2 1.3.9 1.5 1.5.2 1.2.2 2.4 0 3.6z"
                                ></path>
                            </svg>
                        </th>
                        <td><span style="font-weight:500">Viber</span></td>
                        <td>
                            <a
                                href="viber://chat?number=+380683127757"
                                style="color: rgb(238, 56, 64);font-size:14px"
                                target="blank"
                            >Написать</a
                            >
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <svg
                                class="p-1"
                                style="max-width:25px; min-width:20px"
                                text-rendering="geometricPrecision"
                                viewbox="0 0 10 10"
                            >
                                <path
                                    d="M0 10c.1-.2.1-.4.2-.6.2-.6.3-1.2.5-1.8v-.3C-.8 4.4.7.8 4 .1 6.9-.6 9.6 1.4 10 4c.5 2.8-1.3 5.4-4 5.8-1.1.2-2.1 0-3.1-.5h-.3C1.1 9.7.3 10 0 10zm6.3-2.6c-1 0-2.5-.8-3.6-2.7-.3-.7-.3-1.4.3-1.9.2-.2.4-.1.6-.1.1 0 .1.1.1.2.1.3.3.6.4 1 .1.1 0 .3-.3.5-.1.1-.1.2 0 .3.4.7 1 1.2 1.7 1.5.1 0 .2 0 .3-.1.4-.5.4-.6.6-.5 1 .5 1.1.5 1.1.6.1.9-.7 1.2-1.2 1.2zM1.2 8.9c.5-.1 1-.2 1.4-.4h.3c.9.5 1.8.7 2.8.5C8 8.6 9.5 6.5 9.2 4.3 8.8 2 6.6.4 4.3.9 1.5 1.4 0 4.5 1.4 7c.2.3.2.5.1.8-.2.3-.2.7-.3 1.1z"
                                ></path>
                            </svg>
                        </th>
                        <td><span style="font-weight:500">Whatsapp</span></td>
                        <td>
                            <a
                                href="whatsapp://send?phone=+380683127757"
                                style="color: rgb(238, 56, 64);font-size:14px"
                                target="blank"
                            >Написать</a
                            >
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <svg
                                class="p-1"
                                style="max-width:25px; min-width:20px"
                                text-rendering="geometricPrecision"
                                viewbox="0 0 10 10"
                            >
                                <path
                                    d="M9.2 8.5c.2-.1.4-.3.5-.6.4-.9.4-4.5 0-5.4-.1-.4-.4-.6-.7-.8-.6-.2-5.9-.2-7.6 0-.3 0-.6.2-.8.5C0 2.9.1 6.8.4 7.8c.1.4.4.6.8.8.8.2 7.3.2 8-.1zM6.9 5l-3 1.7V3.4l3 1.6z"
                                ></path>
                            </svg>
                        </th>
                        <td><span style="font-weight:500">Youtube</span></td>
                        <td>
                            <a href="https://www.youtube.com/" style="color: rgb(238, 56, 64);font-size:14px" target="_blank"
                            >youtube.com</a
                            >
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <svg class="p-1" style="max-width:25px; min-width:20px" viewbox="0 0 10 10">
                                <path
                                    d="M5.2.5C2.7.5.7 2.5.7 5s2 4.5 4.5 4.5 4.5-2 4.5-4.5C9.6 2.5 7.6.5 5.2.5zm0 8.3C3 8.8 1.3 7 1.3 4.9c0-2.1 1.7-3.8 3.8-3.8S9 2.8 9 4.9C9 7 7.3 8.8 5.2 8.8z"
                                ></path>
                                <path
                                    d="M7.5 4.9H5.3V2.5c0-.2-.1-.3-.3-.3-.2 0-.3.1-.3.3v2.6c0 .2.1.3.3.3h2.4c.2 0 .3-.1.3-.3.1-.1-.1-.2-.2-.2z"
                                ></path>
                            </svg>
                        </th>
                        <td><span style="font-weight:500"><?=GetMessage("WORKING_HOURS")?></span></td>
                        <td><?=GetMessage("HOURS")?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="gtx-trans" style="position: absolute; left: 257px; top: 697px;">
    <div class="gtx-trans-icon">&nbsp;</div>
</div>

<!-- SECTION CONTACT CONTANT END -->
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
