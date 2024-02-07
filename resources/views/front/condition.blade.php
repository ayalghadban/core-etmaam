@extends("front.$version.layout")

@section('pagename')
    - {{ __('app.privecy') }}
@endsection

@section('meta-keywords', __('app.condition_meta_keyword') )
@section('meta-description', __('app.condition_meta_description') )
@section('breadcrumb-title', __('app.conditions'))
@section('breadcrumb-subtitle', $be->pricing_subtitle)
@section('breadcrumb-link', __('app.privecy'))


@section('content')

    <style>
        .box-bank {
            background-color: #ffffff;
        }

        .box-bank {
            border-radius: 0px;
            border: 1px solid #92929e;
            box-shadow: unset;
        }
    </style>
    <div class="container">
        @if ($currentLang->code == 'ar')
            <section
                class="elementor-section elementor-top-section elementor-element elementor-element-d9e6b66 elementor-section-boxed elementor-section-height-default elementor-section-height-default wpr-particle-no wpr-jarallax-no wpr-parallax-no wpr-sticky-section-no"
                data-id="d9e6b66" data-element_type="section"
                data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                <div class="elementor-container elementor-column-gap-no">
                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-daf2e83"
                        data-id="daf2e83" data-element_type="column">
                        <div class="elementor-widget-wrap elementor-element-populated">
                            <div class="elementor-element elementor-element-8ecffdf elementor-widget elementor-widget-image"
                                data-id="8ecffdf" data-element_type="widget" data-widget_type="image.default">
                            </div>
                            <div class="elementor-element elementor-element-34c29c6 elementor-widget elementor-widget-heading"
                                data-id="34c29c6" data-element_type="widget" data-widget_type="heading.default">
                                <div class="elementor-widget-container">
                                    <br> <br>
                                    <h2 class="elementor-heading-title elementor-size-default" style="color: #0A3041">1.
                                        شروط الاستخدام</h2>
                                    <br>
                                </div>
                            </div>
                            <div class="elementor-element elementor-element-988a298 elementor-widget elementor-widget-text-editor"
                                data-id="988a298" data-element_type="widget" data-widget_type="text-editor.default">
                                <div class="elementor-widget-container">
                                    <style>
                                        /*! elementor - v3.6.8 - 27-07-2022 */
                                        .elementor-widget-text-editor.elementor-drop-cap-view-stacked .elementor-drop-cap {
                                            background-color: #818a91;
                                            color: #fff
                                        }

                                        .elementor-widget-text-editor.elementor-drop-cap-view-framed .elementor-drop-cap {
                                            color: #818a91;
                                            border: 3px solid;
                                            background-color: transparent
                                        }

                                        .elementor-widget-text-editor:not(.elementor-drop-cap-view-default) .elementor-drop-cap {
                                            margin-top: 8px;
                                            margin-right: 8px
                                        }

                                        .elementor-widget-text-editor:not(.elementor-drop-cap-view-default) .elementor-drop-cap-letter {
                                            width: 1em;
                                            height: 1em
                                        }

                                        .elementor-widget-text-editor .elementor-drop-cap {
                                            float: left;
                                            text-align: center;
                                            line-height: 1;
                                            font-size: 50px
                                        }

                                        .elementor-widget-text-editor .elementor-drop-cap-letter {
                                            display: inline-block
                                        }

                                        .a-text {
                                            padding-right: 25px;
                                            font-size: 25px;
                                        }

                                        .ul-text {
                                            padding-right: 60px;
                                            color: black;
                                        }

                                        .b-text {
                                            padding-right: 80px
                                        }

                                        .c-text {
                                            padding-right: 90px;
                                            font-size: 25px
                                        }
                                    </style>
                                    <div class="privacyContent">
                                        <p class="a-text">يقر المستخدم لمنصة إتمام بالامتناع عما يلي:<br></p>
                                        <br>
                                        <ol class="ul-text" style="list-style-type: disc;">
                                            <li style="color: black; font-size: 25px;">توفير أو تحميل ملفات تحتوي على
                                                برمجيات، أو مواد، أو بيانات، أو معلومات أخرى ليست مملوكة لك أو لا تملك
                                                ترخيصًا بشأنها.</li>
                                            <li style="color: black; font-size: 25px;">استخدام هذه المنصة بأي طريقة لإرسال
                                                أي بريد إلكتروني تجاري أو غير مرغوب فيه، أو أي إساءة استخدام من هذا النوع.
                                            </li>
                                            <li style="color: black; font-size: 25px;">رفع أو تحميل ملفات على هذه المنصة
                                                تحتوي على فيروسات، أو بيانات تالفة، أو أي برمجيات خبيثة، أو القيام بكل ما من
                                                شأنه التأثير على سلامة المعلومات في المنصة أو موثوقيتها أو استمرار توفرها.
                                            </li>
                                            <li style="color: black; font-size: 25px;">نشر، أو إعلان، أو توزيع، أو تعميم
                                                مواد، أو معلومات تحتوي تشويهًا للسمعة، أو انتهاكًا للقوانين، أو مواد إباحية،
                                                أو بذيئة، أو مخالفة للآداب العامة، أو أي مواد، أو معلومات غير قانونية.</li>
                                            <li style="color: black; font-size: 25px;">استخدام أي وسيلة، أو برنامج، أو إجراء
                                                لاعتراض، أو محاولة اعتراض التشغيل الصحيح.</li>
                                            <li style="color: black; font-size: 25px;">القيام بأي إجراء يفرض حملًا غير معقول
                                                أو كبير بصورة غير مناسبة على البنية التحتية للمنصة.</li>
                                            <li style="color: black; font-size: 25px;">كل ما يعد مخالفة لأنظمة المملكة
                                                العربية السعودية وعلى وجه الخصوص نظام مكافحة الجرائم المعلوماتية، ونظام
                                                حماية البيانات الشخصية، ونظام التعاملات الإلكترونية.</li>

                                        </ol>
                                        </p>
                                        <br> <br>
                                        <h2 style="color: #0A3041">2. استخدام الروابط</h2>
                                        <br>
                                        <p class="a-text">يمنع إنشاء أو نقل أو نسخ أي روابط إلكترونية تتعلق بالبوابة، أو نشر
                                            هذه الروابط في مواقع أخرى، باستثناء نشر الروابط الفعلية للمنصة في المواقع التي
                                            لا تتعارض أهدافها وتوجهاتها مع أهداف وتوجهات وسياسات إتمام.</p>
                                        <br>
                                        <p class="a-text">
                                        <ol style="padding-right:110px; list-style-type: disc;">
                                            <li style="color: black; font-size: 25px;">يمنع إنشاء أو نقل أو نسخ أي روابط
                                                إلكترونية تتعلق بموقع إتمام، أو نشر هذه الروابط في مواقع أخرى، باستثناء نشر
                                                الروابط الفعلية للمنصة في المواقع التي لا تتعارض أهدافها وتوجهاتها مع أهداف
                                                وتوجهات وسياسات إتمام.</li>
                                            <li style="color: black; font-size: 25px;">تحتفظ إتمام بالحق في فرض أي شروط عند
                                                السماح بإنشاء أي رابط إلكتروني للمنصة أو أي من محتوياتها.</li>
                                            <li style="color: black; font-size: 25px;">لا تعتبر إتمام مشاركًا أو مرتبطًا بأي
                                                حال من الأحوال بأي علامات، أو شعارات، أو رموز تجارية، أو خدمية، أو أي وسائل
                                                أخرى مستخدمة أو تظهر على مواقع الويب المتضمنة لروابط تقود إلى موقع إتمام أو
                                                أي من محتوياته مالم تكن معتمدة لدى الإدارة المختصة لديها.</li>
                                            <li style="color: black; font-size: 25px;">تحتفظ إتمام بكامل حقوقه في إيقاف
                                                وإعاقة أي ارتباط بأي شكل من الأشكال من أي موقع غير مصرح به أو يحتوي على
                                                مواضيع غير ملائمة، أو فاضحة، أو متعدية، أو بذيئة، أو إباحية، أو غير لائقة،
                                                أو غير قانونية، أو أسماء، أو مواد، أو معلومات تخالف أي نظام أو تنتهك أي حقوق
                                                عامة أو خاصة.</li>
                                            <li style="color: black; font-size: 25px;">لا تتحمل إتمام أي مسؤولية عن
                                                المحتويات المتوفرة في أي موقع آخر يتم الوصول منه إلى موقع إتمام.</li>
                                            <li style="color: black; font-size: 25px;">تطلب الإدارة المختصة لدى إتمام
                                                الموافقة على أي ارتباط إلكتروني يرتبط بالمنصة أو محتوياتها، وقد تتطلب
                                                إجراءات تقديم معلومات وتفاصيل إضافية قبل الموافقة.</li>
                                            <li style="color: black; font-size: 25px;">يجب أن يكون الرابط الإلكتروني للمنصة
                                                أو محتوياتها واضحًا وصحيحًا، ولا يجوز تضليل الزوار بشأن مصدر الرابط أو
                                                محتواه.</li>
                                            <li style="color: black; font-size: 25px;">يجب أن يتم احترام جميع حقوق الملكية
                                                الفكرية المتعلقة بموقع إتمام ومحتوياته، وعدم التلاعب بأي جوانب تقنية أو
                                                محتوى يخرق هذه الحقوق.</li>
                                            <li style="color: black; font-size: 25px;">يحق لإتمام تعديل هذه الشروط والأحكام
                                                في أي وقت دون إشعار مسبق. يُنصح بمراجعة هذه الصفحة بشكل دوري للتعرف على أي
                                                تحديثات.</li>
                                            <li style="color: black; font-size: 25px;">باستخدامك لأي رابط إلكتروني لموقع
                                                إتمام، فإنك توافق على جميع شروط وأحكام هذا البند وتلتزم بها.</li>

                                        </ol>
                                        </p>
                                        <br>
                                        <br>
                                        <br>
                                        <h2 style="color: #0A3041">3. الحماية من الفيروسات</h2> <br>
                                        <p class="a-text">نسعى جاهدين في موقع إتمام لفحص واختبار
                                            كل محتوى الموقع خلال عمليات الإنتاج. نلفت انتباه المستخدمين إلى ضرورة تشغيل
                                            برامج مضادات الفيروسات للتأكد من سلامة المواد التي يتم تنزيلها من الإنترنت.
                                            وتجدر الملاحظة أننا لسنا مسؤولين عن أية خسائر أو تلف في البيانات أو الأجهزة التي
                                            قد تحدث أثناء استخدام الموقع.
                                            <br>
                                            نطلب من المستخدمين الإبلاغ عن أي ممارسات خاطئة أو ثغرات أمنية
                                            تشتبهون في وجودها وقد تؤثر على أمان الموقع. يمكنكم الإبلاغ عبر البريد
                                            الإلكتروني: info@etmaam.com.sa
                                            يجب الالتزام بهذا الإجراء وإلا قد تترتب مسائلة قانونية.
                                            يرجى اتخاذ الاحتياطات اللازمة لحماية معداتك وبياناتك من الفيروسات والبرمجيات
                                            الخبيثة أثناء تصفح الموقع أو تنزيل المحتوى منه
                                        </p>
                                        <br> <br>
                                        <h2 style="color: #0A3041">4. المطالبات</h2>
                                        <p class="a-text">تقدم منصة إتمام خدماتها، بالإضافة إلى المعلومات والمواد والوظائف
                                            المتاحة من خلالها، "كما هي" و"كما متاحة" دون أي تأكيدات أو وعود أو ضمانات من أي
                                            نوع. لا يمكن لإتمام أن تكفل أو تتحمل المسؤولية عن أي انقطاعات أو أخطاء أو
                                            تجاوزات قد تنشأ نتيجة استخدام هذه المنصة أو محتوياتها أو أي موقع مرتبط بها، سواء
                                            كان ذلك بعلمها أو بدون علمها.
                                            أي اتصالات أو معلومات يرسلها المستخدمون عبر هذه المنصة لن يكون لهم حق الملكية
                                            فيها أو حق ضمان سريتها. وأي استخدام أو تفاعل تفاعلي مع هذه الخدمة لا يهدف إلى
                                            ضمان أي حقوق أو تراخيص أو امتيازات للمستخدم من أي نوع.
                                        </p>
                                        <br>
                                        <h2 style="color: #0A3041">5. المسؤولية</h2>
                                        <p class="a-text"> تُقدم منصة إتمام خدماتها ومعلوماتها عبر الإنترنت بهدف تسهيل
                                            الإجراءات اليدوية المتعلقة بالدوائر والجهات الحكومية المختلفة.
                                            يتعين على المستخدم أن يكون واعيًا بأن الاتصال عبر شبكة الإنترنت قد يتعرض للتدخل
                                            أو الاعتراض من قِبَل أطراف غير مخولة، وأن المعلومات المتاحة عبر المنصة لا تستبدل
                                            المعلومات المتاحة من خلال الجهات الرسمية.

                                            إضافة انه يجب على المستخدم أن يدرك أن الطلبات والإجراءات الإدارية يمكن تقديمها
                                            مباشرة أمام الجهات المختصة، وعليه يظل اللجوء إلى المنصة مسؤولية المستخدم. لا
                                            تتحمل منصة إتمام أية مسؤولية عن أي خسائر أو أضرار من أي نوع قد تكون نتيجة
                                            للاعتماد على أية معلومات أو بيانات أو آراء تقدمها المنصة.

                                            المستخدم يقر ويوافق على أن وسيلته الحصرية لمعالجة أية خسائر أو أضرار قد تحدث
                                            نتيجة استخدامه للمنصة هي الامتناع عن استخدامها أو دخولها أو الاستمرار في ذلك.
                                        </p>
                                        <br>
                                        <h2 style="color: #0A3041">6. التعويض</h2>
                                        <p class="a-text">يقر المستخدم بإبراء وعدم اتخاذ أي إجراء ضد إتمام أو أي من إداراتها
                                            وموظفيها والمسؤولين عن إدارة منصتها وصيانتها وتحديثها، ويعفيهم من جميع
                                            الالتزامات والمسؤوليات والتعويضات الناشئة أو التي قد تنشأ عن استخدام المنصة أو
                                            بسببها.</p>
                                        <br>

                                        <h2 style="color: #0A3041">7. حقوق الملكية</h2>
                                        <p class="a-text">تعد جميع محتويات المنصة من خدمات ومعلومات ملكًا لإتمام، وهي محمية
                                            بالكامل طبقا للأنظمة والاتفاقيات السعودية لحقوق النشر والعلامات التجارية وحقوق
                                            الملكية المختلفة.
                                            المواد المتوفرة في هذه الخدمة بما في ذلك الرسوم التصويرية للمعلومات والبرمجيات
                                            (المحتويات) محمية بموجب حقوق النشر والعلامات التجارية، وأشكال حقوق الملكية
                                            الأخرى ولا يجوز استنساخها أو استغلالها بأي طريقة كانت، دون موافقة خطية مسبقة من
                                            إدارة المنصة.
                                            وما لم ينص على خلاف ذلك، لا يجوز بيع، أو ترخيص، أو تأجير، أو تعديل، أو نسخ، أو
                                            استنساخ، أو إعادة طبع، أو تحميل، أو إعلان، أو نقل، أو توزيع، أو العرض بصورة
                                            علنية، أو تحرير، أو إنشاء أعمال مشتقة من أي مواد أو محتويات من هذه البوابة
                                            للجمهور أو لأغراض تجارية، دون الحصول على الموافقة الخطية المسبقة من قبل إدارة
                                            إتمام الإنجاز لخدمات الأعمال.
                                        </p>
                                        <br>

                                        <h2 style="color:#0A3041">8. المرجعية القضائية</h2>
                                        <p class="a-text">يخضع المستخدم لأنظمة المملكة العربية السعودية، ومحاكمها هي المختصة
                                            بنظر الدعاوى الناشئة عن هذه السياسة، وعلى وجه الخصوص يخضع المستخدم لأحكام نظام
                                            مكافحة الجرائم المعلوماتية ونظام حماية البيانات الشخصية في حال ارتكابه أحد
                                            المخالفات المنصوص عليها في النظام، كما يخضع المستخدم للمساءلة القانونية في حال
                                            إساءة استخدامه للمنصة.</p>
                                        <br>
                                        <br>
                                        <h2 style="color:#0A3041">9. المرجعية القضائية</h2>
                                        <ol
                                            style="color: black; font-size: 25px; padding-right:110px; list-style-type: disc;">
                                            <li>جميع المواد والمعلومات المقدمة عبر المنصة هي توعية وغير هادفة للربح.</li>
                                            <li>اللغة العربية هي اللغة الرئيسية للاستفادة من المواد المنشورة على المنصة،
                                                وترجمتها تُقدم كخدمة إضافية. لا يعتمد التفسير على الترجمة في حالة حدوث
                                                خلافات حول محتوى المنصة.</li>
                                            <li>اللوائح والأنظمة المعروضة على المنصة، سواء لإتمام أو لجهات أخرى، قد تخضع
                                                للترجمة و التوضيح، ولكن النص العربي يظل المرجع الأساسي.</li>
                                            <li>تحتوي المنصة على وسائل مشاركة إلكترونية مثل المنتديات ومنصة الاستفسارات،
                                                ويجب الامتثال للمعايير والقيود المعمول بها في استخدام هذه الوسائل.</li>
                                            <li>المنصة تمتلك الحق في حذف التعليقات أو المشاركات التي تعتبر غير مناسبة.</li>
                                            <li>للاستفسارات حول الشروط والأحكام، يمكن التواصل مع إدارة المنصة عبر نموذج
                                                الاتصال في الصفحة الرئيسية.</li>
                                        </ol>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @elseif($currentLang->code == 'en')
            <section
                class="elementor-section elementor-top-section elementor-element elementor-element-d9e6b66 elementor-section-boxed elementor-section-height-default elementor-section-height-default wpr-particle-no wpr-jarallax-no wpr-parallax-no wpr-sticky-section-no"
                data-id="d9e6b66" data-element_type="section"
                data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                <div class="elementor-container elementor-column-gap-no">
                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-daf2e83"
                        data-id="daf2e83" data-element_type="column">
                        <div class="elementor-widget-wrap elementor-element-populated">
                            <div class="elementor-element elementor-element-8ecffdf elementor-widget elementor-widget-image"
                                data-id="8ecffdf" data-element_type="widget" data-widget_type="image.default">
                            </div>
                            <div class="elementor-element elementor-element-34c29c6 elementor-widget elementor-widget-heading"
                                data-id="34c29c6" data-element_type="widget" data-widget_type="heading.default">
                                <div class="elementor-widget-container">
                                    <br> <br>
                                    <h2 class="elementor-heading-title elementor-size-default" style="color: #0A3041">
                                        1. Terms of Use</h2>
                                    <br>
                                </div>
                            </div>
                            <div class="elementor-element elementor-element-988a298 elementor-widget elementor-widget-text-editor"
                                data-id="988a298" data-element_type="widget" data-widget_type="text-editor.default">
                                <div class="elementor-widget-container">
                                    <style>
                                        /*! elementor - v3.6.8 - 27-07-2022 */
                                        .elementor-widget-text-editor.elementor-drop-cap-view-stacked .elementor-drop-cap {
                                            background-color: #818a91;
                                            color: #fff
                                        }

                                        .elementor-widget-text-editor.elementor-drop-cap-view-framed .elementor-drop-cap {
                                            color: #818a91;
                                            border: 3px solid;
                                            background-color: transparent
                                        }

                                        .elementor-widget-text-editor:not(.elementor-drop-cap-view-default) .elementor-drop-cap {
                                            margin-top: 8px;
                                            margin-left: 8px
                                        }

                                        .elementor-widget-text-editor:not(.elementor-drop-cap-view-default) .elementor-drop-cap-letter {
                                            width: 1em;
                                            height: 1em
                                        }

                                        .elementor-widget-text-editor .elementor-drop-cap {
                                            float: left;
                                            text-align: center;
                                            line-height: 1;
                                            font-size: 50px
                                        }

                                        .elementor-widget-text-editor .elementor-drop-cap-letter {
                                            display: inline-block
                                        }

                                        .a-text {
                                            padding-left: 25px;
                                            font-size: 25px;
                                        }

                                        .ul-text {
                                            padding-left: 60px;
                                            color: black;
                                        }

                                        .b-text {
                                            padding-left: 80px
                                        }

                                        .c-text {
                                            padding-left: 90px;
                                            font-size: 25px
                                        }
                                    </style>
                                    <div class="privacyContent">
                                        <p class="a-text">The user of the Itmam platform acknowledges refraining from the
                                            following:<br></p>
                                        <br>
                                        <ol style="list-style-type: disc; padding-left:110px;">
                                            <li style="color: black; font-size: 25px;">Providing or uploading files
                                                containing software, materials, data, or other information that you do not
                                                own or have a license for.</li>
                                            <li style="color: black; font-size: 25px;">Using this platform in any way to
                                                send any commercial or unwanted email or any misuse of this kind.</li>
                                            <li style="color: black; font-size: 25px;">Uploading files to this platform that
                                                contain viruses, corrupted data, or any malicious software or engaging in
                                                any activity that may impact the integrity, reliability, or continued
                                                availability of the information on the platform.</li>
                                            <li style="color: black; font-size: 25px;">Publishing, advertising,
                                                distributing, or disseminating materials or information that defame, violate
                                                laws, contain pornography, are obscene, violate public decency, or any
                                                illegal materials or information.</li>
                                            <li style="color: black; font-size: 25px;">Using any means, program, or action
                                                to obstruct or attempt to obstruct proper operation.</li>
                                            <li style="color: black; font-size: 25px;">Taking any action that unreasonably
                                                or disproportionately imposes a burden on the platform's infrastructure.
                                            </li>
                                            <li style="color: black; font-size: 25px;">Anything that violates the
                                                regulations of the Kingdom of Saudi Arabia, especially the Anti-Cybercrime
                                                Law, Personal Data Protection Law, and Electronic Transactions Law.</li>
                                        </ol>
                                        </p>
                                        <br> <br>
                                        <h2 style="color: #0A3041">2. Using Links</h2>
                                        <br>
                                        <p class="a-text">Creating, transferring, or copying any electronic links related
                                            to the platform, or posting these links on other sites, except for posting the
                                            actual links to the platform on sites whose objectives and policies do not
                                            conflict with Itmam's objectives and policies.</p>
                                        <br>

                                        <p class="a-text">
                                        <ol style="padding-left:110px; list-style-type: disc;">
                                            <li style="color: black; font-size: 25px;">Creating, transferring, or copying
                                                any electronic links related to the Itmam platform, or posting these links
                                                on other sites, except for posting the actual links to the platform on sites
                                                whose objectives and policies do not conflict with Itmam's objectives and
                                                policies.</li>
                                            <li style="color: black; font-size: 25px;">Itmam reserves the right to impose
                                                any conditions when allowing the creation of any electronic link to the
                                                platform or any of its contents.</li>
                                            <li style="color: black; font-size: 25px;">Itmam is not considered associated
                                                or affiliated in any way with any trademarks, logos, service marks, or any
                                                other means used or appearing on websites that include links leading to the
                                                Itmam platform or any of its contents, unless approved by the relevant
                                                management.</li>
                                            <li style="color: black; font-size: 25px;">Itmam retains all rights to suspend
                                                and disable any link in any form from any unauthorized site or containing
                                                inappropriate, offensive, obscene, indecent, pornographic, illegal, or
                                                inappropriate content or names, materials, or information that violate any
                                                public or private laws.</li>
                                            <li style="color: black; font-size: 25px;">Itmam bears no responsibility for
                                                the contents available on any other site accessed through Itmam.</li>
                                            <li style="color: black; font-size: 25px;">The competent management at Itmam
                                                may require approval for any electronic link related to the platform or its
                                                contents, and additional information and details may be required before
                                                approval.</li>
                                            <li style="color: black; font-size: 25px;">The electronic link to the platform
                                                or its contents must be clear and accurate, and visitors should not be
                                                misled about the source or content of the link.</li>
                                            <li style="color: black; font-size: 25px;">All intellectual property rights
                                                related to the Itmam website and its contents must be respected, and no
                                                manipulation of any technical aspects or content that violates these rights
                                                is allowed.</li>
                                            <li style="color: black; font-size: 25px;">Itmam reserves the right to amend
                                                these terms and conditions at any time without prior notice. It is advisable
                                                to regularly review this page for any updates.</li>
                                            <li style="color: black; font-size: 25px;">By using any electronic link to the
                                                Itmam website, you agree to all the terms and conditions of this clause and
                                                commit to abide by them.</li>
                                        </ol>
                                        </p>
                                        <br>
                                        <br>
                                        <br>
                                        <h2 style="color: #0A3041">3. Protection from Viruses</h2>
                                        <br>
                                        <p class="a-text">We at the Itmam website make every effort to examine and test all
                                            site content during production processes. We urge users to run antivirus
                                            software to ensure the safety of materials downloaded from the internet. Please
                                            note that we are not responsible for any loss or damage to data or devices that
                                            may occur during website usage.<br>
                                            We ask users to report any improper practices or security vulnerabilities they
                                            suspect may affect the site's security. You can report via email:
                                            info@etmaam.com.sa. This procedure must be adhered to, or legal action may be
                                            taken. Please take the necessary precautions to protect your equipment and data
                                            from viruses and malicious software while browsing the site or downloading
                                            content from it.</p>

                                        <br> <br>
                                        <h2 style="color: #0A3041">4. Claims</h2>
                                        <p class="a-text">Itmam platform provides its services, as well as the information
                                            and materials available through it, "as is" and "as available" without any
                                            representations, warranties, or guarantees of any kind. Itmam cannot assure or
                                            be responsible for any interruptions, errors, or deviations that may arise from
                                            using this platform or its contents or any linked sites, whether knowingly or
                                            unknowingly.
                                            Any communications or information sent by users through this platform will not
                                            be owned by them, and they will have no rights to its confidentiality. Any use
                                            or interactive interaction with this service is not intended to guarantee any
                                            rights, licenses, or privileges for the user of any kind.
                                        </p>
                                        <br>
                                        <h2 style="color: #0A3041">5. Liability</h2>
                                        <p class="a-text">Itmam platform provides its services and information online with
                                            the aim of facilitating manual procedures related to various government
                                            departments and entities.
                                            The user should be aware that internet communication may be subject to
                                            interference or interception by unauthorized parties, and the information
                                            available through the platform does not replace the information available from
                                            official authorities.
                                            Additionally, the user should be aware that requests and administrative
                                            procedures can be directly submitted to the relevant authorities, and therefore,
                                            it remains the responsibility of the user to resort to the platform. Itmam
                                            platform bears no responsibility for any losses or damages of any kind that may
                                            result from relying on any information, data, or opinions provided by the
                                            platform.
                                            The user acknowledges and agrees that their sole recourse for addressing any
                                            losses or damages that may occur as a result of their use of the platform is to
                                            refrain from using it, accessing it, or continuing to do so.
                                        </p>
                                        <br>

                                        <h2 style="color: #0A3041">6. Compensation</h2>
                                        <p class="a-text">The user acknowledges and agrees not to take any action against
                                            Itmam or any of its administrations, employees, or those responsible for the
                                            management, maintenance, and updates of its platform. The user releases them
                                            from all obligations, responsibilities, and compensations arising or that may
                                            arise from the use of the platform or because of it.</p>
                                        <br>

                                        <h2 style="color: #0A3041">7. Intellectual Property Rights</h2>
                                        <p class="a-text">All content on the platform, including services and information,
                                            belongs to Itmam and is fully protected under Saudi copyright laws, trademark
                                            rights, and various other intellectual property rights.
                                            The materials available on this platform, including graphics, information, and
                                            software (content), are protected by copyright, trademark rights, and other
                                            forms of intellectual property rights and may not be copied or exploited in any
                                            way without prior written consent from the platform's management.
                                            Unless otherwise specified, it is prohibited to sell, license, lease, modify,
                                            copy, reproduce, reprint, download, advertise, transmit, distribute, publicly
                                            display, edit, or create derivative works from any materials or contents of this
                                            business services portal for the public or commercial purposes without obtaining
                                            prior written approval from Itmam's Business Services Management.</p>
                                        <br>

                                        <h2 style="color: #0A3041">8. Judicial Jurisdiction</h2>
                                        <p class="a-text">The user is subject to the laws of the Kingdom of Saudi Arabia,
                                            and its courts have jurisdiction over claims arising from this policy.
                                            Specifically, the user is subject to the provisions of the Anti-Cybercrime Law
                                            and Personal Data Protection Law if they commit any violations stipulated in
                                            these laws. The user may also be legally accountable for any misuse of the
                                            platform.</p>
                                        <br>

                                        <h2 style="color: #0A3041">9. Legal Reference</h2>
                                        <ol
                                            style="color: black; font-size: 25px; padding-left: 110px; list-style-type: disc;">
                                            <li>All materials and information provided through the platform are for
                                                awareness and non-profit purposes.</li>
                                            <li>The Arabic language is the primary language for benefiting from the
                                                materials published on the platform, and its translation is provided as an
                                                additional service. Interpretation is not based on translation in case of
                                                disputes regarding the platform's content.</li>
                                            <li>The regulations and rules displayed on the platform, whether for Itmam or
                                                other entities, may be subject to translation and clarification, but the
                                                Arabic text remains the primary reference.</li>
                                            <li>The platform includes electronic sharing methods such as forums and inquiry
                                                platforms, and compliance with the applicable standards and restrictions in
                                                using these methods is required.</li>
                                            <li>The platform reserves the right to delete comments or posts that are
                                                considered inappropriate.</li>
                                            <li>For inquiries regarding terms and conditions, you can contact the platform's
                                                management through the contact form on the homepage.</li>
                                        </ol>
                                        <br>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </div>

@endsection
