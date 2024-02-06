@extends("front.$version.layout")

@section('pagename')
    - {{ __('app.privecy') }}
@endsection

@section('meta-keywords', "$be->packages_meta_keywords")
@section('meta-description', "$be->packages_meta_description")
@section('breadcrumb-title', __('app.privecy'))
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
                                    <h2 class="elementor-heading-title elementor-size-default" style="color: #0A3041">1. من
                                        نحن</h2>
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
                                        <p class="a-text">تلتزم إتمام بأعلى معايير المستهلك لحماية مستخدميها و من تقدم لهم
                                            خدماتها.</p> <br>
                                        <p class="a-text">
                                            قامت إتمام بإنشاء سياسة الخصوصية واضعة إياك في عين الاعتبار, و من الضروري أن
                                            يكون لديك فهم شامل لأساليب جمع المعلومات و استخدامها آخذاً في عين الاعتبار أنك
                                            المتحكم الأول و الأخير في معلوماتك الشخصية المقدمة إلى إتمام. بعد قراءة سياسة
                                            الخصوصية ستلاحظ أنه باستخدام صفحة إتمام على الويب:
                                            <br><br>
                                        <ol class="ul-text" style="list-style-type: disc;">
                                            <li style="color: black; font-size: 25px;"> أنت توافق على أنه إذا قمت بالإفصاح
                                                عن معلوماتك الشخصية لنا، فقد نقوم بإنشاء سجل قاعدة بيانات عنك</li>
                                            <li style="color: black; font-size: 25px;"> إذا قمت بالتسجيل على موقعنا
                                                الإلكتروني، أو قمت بتنزيل أي مواد أو إجراء أي معاملة أخرى، فإنك توافق على
                                                قيامنا بجمع المعلومات اللازمة لتزويدك بالخدمة التي طلبتها، وتوافق على أنه
                                                يجوز الكشف عن هذه المعلومات لشركاء الخدمة (الذين قد يكونوا أطراف ثالثة) لتلك
                                                الأغراض</li>
                                            <li style="color: black; font-size: 25px;"> أنت توافق على استخدام ملفات تعريف
                                                الارتباط على متصفحك (ما لم تقم بإزالتها)</li>
                                            <li style="color: black; font-size: 25px;"> أنت توافق على أنه يمكننا الاتصال بك
                                                لتزويدك بمعلومات حول المنتجات والخدمات التي قد تهمك (ما لم تكن قد ذكرت أنك
                                                لا ترغب في تلقي هذه الاتصالات)</li>
                                            <li style="color: black; font-size: 25px;"> يفيد استخدامك المستمر لموقع "إتمام"
                                                على الويب بموافقتك على أي تغييرات مستقبلية في سياسة خصوصية "إتمام"</li>
                                        </ol>
                                        </p>
                                        <br> <br>
                                        <h2 style="color: #0A3041">2. ما المعلومات التي يتم جمعها وكيف نستخدمها؟</h2>
                                        <br>
                                        <p class="a-text">تقوم "إتمام" بجمع المعلومات منك في عدة نقاط مختلفة على الموقع:</p>
                                        <br>
                                        <h3 class="b-text">أ. طلب خدمة</h3>
                                        <br>
                                        <strong class="c-text">ما المعلومات التي يتم جمعها؟</strong> <br>
                                        <p class="a-text">
                                        <ol style="padding-right:110px; list-style-type: disc;">
                                            <li style="color: black; font-size: 25px;">عند طلب خدمة من إتمام, سيطلب منك ترك
                                                بريدك الالكتروني, بالإضافة لرقم هاتفك و اسمك الكامل, مصحوبين بالمدينة التي
                                                تقيم فيها (إن كنت تستخدم النموذج الكامل).</li>
                                            <li style="color: black; font-size: 25px;">يتم أخذ عنوان بروتوكول الانترنت الخاص
                                                بك (عنوان بروتوكول الإنترنت الخاص بك هو الرقم الخاص بجهاز الحاسوب الذي
                                                تستخدمه، والذي يسمح للأجهزة الأخرى الموصولة بشبكة الإنترنت بتحديد وجهة
                                                البيانات الصادرة عنها، وجمع بعض المعلومات مثل نوعية المتصفح ومحرك البحث،
                                                ولكن من دون التعرف على هويتك الشخصية).</li>
                                            <li style="color: black; font-size: 25px;">يتم منحك أيضًا خيار التسجيل للحصول
                                                على تحديثات دورية و/أو رسائل إخبارية من "دفترة" لإعلامك بآخر الأخبار
                                                والصفقات.</li>
                                        </ol>
                                        </p>
                                        <br>
                                        <strong class="c-text">لمَ نجمع هذه المعلومات؟</strong>
                                        <br>
                                        <p class="c-text" style="padding-right: 120px">
                                            نجمع المعلومات المذكورة أعلاه للأغراض التالية:</p>
                                        <br>
                                        <ol style="padding-right: 140px; list-style-type: disc;">
                                            <li style="color: black; font-size: 25px;">لتحديد هويتك عند استخدام موقعنا من
                                                أجل التمتع بتجربة شخصية ومخصصة.</li>
                                            <li style="color: black; font-size: 25px;">لتقديم مخطط شاشة افتراضي لك بناءً على
                                                البلد الذي تحدده</li>
                                            <li style="color: black; font-size: 25px;">كإجراء أمني، لإرسال بريد إلكتروني
                                                إليك لتأكيد تسجيل حسابك</li>
                                            <li style="color: black; font-size: 25px;">للسماح لنا بمعالجة واستكمال خدماتك
                                            </li>
                                            <li style="color: black; font-size: 25px;">لإتاحة تجربة سلسة عند إجراء عمليات
                                                الطلب المستقبلية.</li>
                                            <li style="color: black; font-size: 25px;">لإرسال تأكيدات عبر البريد الإلكتروني
                                                لاتخاذ إجراءات بشأن "إتمام".</li>
                                            <li style="color: black; font-size: 25px;">لتأكيد هويتك و توثيقها.</li>
                                            <li style="color: black; font-size: 25px;">بالنسبة لوكلاء خدمة العملاء لدينا،
                                                للتواصل معك عند الضرورة.</li>
                                            <li style="color: black; font-size: 25px;">لإرسال تحديثاتنا الدورية و/أو رسائلنا
                                                الإخبارية إليك اختياريًا، إذا قمت بالتسجيل للحصول عليها.</li>
                                            <li style="color: black; font-size: 25px;">لإرسال معلومات إليك حول المنتجات و
                                                الخدمات التي قد تهمك.</li>
                                        </ol>
                                        <br>
                                        <h3 class="b-text">ب. التواصل مع العميل</h3> <br>
                                        <strong class="c-text">ما المعلومات التي يتم جمعها؟</strong> <br>
                                        <p class="c-text" style="padding-right:150px">يمكنك اختيار تقديم ملحوظات إلى
                                            "إتمام"، على سبيل المثال من خلال البريد الإلكتروني أو الرسائل. وقد يتم الاحتفاظ
                                            بالتعليقات الواردة في ملحوظات، بالإضافة إلى معلومات التواصل الخاصة بك مثل بريدك
                                            الإلكتروني، إذا تم تقديمها إلى "إتمام"، في سجلات.</p><br>
                                        <strong class="c-text">لمَ نجمع هذه المعلومات؟</strong> <br>
                                        <ol style="padding-right: 160px; list-style-type: disc;">
                                            <li style="color: black; font-size: 25px;">تعد الملحوظات التي تختار تقديمها ذات
                                                قيمة لمساعدة "إتمام" في إجراء تحسينات على خدمتنا المقدمة لك. من أجل متابعة
                                                الملحوظات التي اخترت تقديمها، قد تقوم "إتمام" بمراسلتك باستخدام معلومات
                                                التواصل التي قدمتها.</li>
                                            <li style="color: black; font-size: 25px;">لإرسال معلومات إليك حول المنتجات
                                                والخدمات التي قد تهمك</li>
                                        </ol>
                                        <br>
                                        <h3 class="b-text">ج. ملفات تعريف الارتباط</h3> <br>
                                        <strong class="c-text">ما المعلومات التي يتم جمعها؟</strong> <br>
                                        <p class="c-text" style="padding-right: 170px;">
                                            عند زيارة موقع "إتمام", يتم تخزين ملف تعريف الارتباط على جهاز الكمبيوتر لديك
                                            (يعد ملف تعريف الارتباط ملفًا نصيًا صغيرًا ومشفّرًا يحتوي على بعض المعلومات حول
                                            تفضيلاتك ويسمح بتتبع استخدامك), ويعد استخدام ملفات تعريف الارتباط الآن معيارًا
                                            صناعيًا، وستجدها مستخدمة في معظم مواقع الويب الرئيسية. على الرغم من ذلك، يمكنك
                                            دائمًا اختيار تعطيل تخزين ملفات تعريف الارتباط على جهاز الكمبيوتر لديك عن طريق
                                            تغيير إعدادات المتصفح. فيما قد يؤدي تعطيل ملفات تعريف الارتباط إلى الحصول على
                                            تجربة محدودة لوظائفنا وخدماتنا وفي بعض الحالات قد يعني أننا غير قادرين على
                                            تزويدك بالخدمات أو أجزاء من الخدمات التي طلبتها. وقد يتم استخدام ملفات تعريف
                                            الارتباط أيضًا من قِبَل بعض شركاء الأعمال لدينا الذين تم دمج محتواهم في موقعنا
                                            أو ارتبط به. ومع ذلك، ليس لدينا صلاحية وصول إلى ملفات تعريف الارتباط هذه أو
                                            التحكم فيها.
                                        </p>
                                        <br>
                                        <strong class="c-text">لمَ نجمع هذه المعلومات؟</strong> <br>
                                        <p class="c-text">تُسهل ملفات تعريف الارتباط، عند تخزينها على جهاز الكمبيوتر لديك،
                                            ما يلي:
                                            <br>
                                        <ol class="c-text" style="padding-right: 150px" style="list-style-type: disc;">
                                            <li>تتيح لنا ملفات تعريف الارتباط حفظ كلمات المرور والتفضيلات نيابة عنك حتى لا
                                                تضطر إلى إعادة إدخالها في المرة التالية التي تزورنا فيها. وهذا يعني أنك
                                                ستتمكن من الحصول على تجربة أكثر راحة.</li>
                                            <li>ستتمكن "إتمام" من إجراء تحسينات على الموقع بناءً على إحصاءات الاستخدام
                                                المجمعة التي تم جمعها من ملفات تعريف الارتباط. فيما تكون إحصاءات الاستخدام
                                                المجمعة هذه مجهولة المصدر لأطراف ثالثة، ويمكن أيضًا استخدامها من قبل شركات
                                                الإعلان من أطراف ثالثة ذات صلة بـ "إتمام" لمراقبة فعالية الإعلانات.</li>
                                        </ol>
                                        </p>
                                        <h2 style="color:#0A3041; ">3. معلوماتك تحت سيطرتك الشخصية </h2>
                                        <br>
                                        <h3 class="b-text">أ. سياسة الاشتراك وإلغاء الاشتراك</h3>
                                        <br>
                                        <p class="c-text">لديك دائمًا خيار الاشتراك في المشاركة في عروض منتجات وخدمات
                                            "إتمام". على سبيل المثال، سيتم منحك خيار الاشتراك في نشرة "إتمام" الإخبارية من
                                            خلال النقر فوق مربع الاختيار.
                                            بينما يتمل "إتمام" في استفادتك من عروض منتجاتنا وخدماتنا، في أي وقت، لديك دائمًا
                                            خيار إلغاء الاشتراك في المنتجات والخدمات التي اشتركت فيها.
                                            فيما نوفر لك القدرة على إلغاء الاشتراك في تلقي معلومات منتجاتنا وخدماتنا عند
                                            مرحلة جمع المعلومات، أو عن طريق الوصول إلى معلومات حسابك وتغييرها، فيرجى إتاحة
                                            بعض الوقت لمعالجة هذا الطلب.
                                        </p>
                                        <br>
                                        <h3 class="b-text">ب. الوصول إلى معلوماتك والاحتفاظ بالمعلومات</h3>
                                        <br>
                                        <p class="c-text">على الرغم من أننا سنتخذ خطوات معقولة للحفاظ على دقة معلوماتك
                                            واكتمالها وتحديثها، فإننا نطلب منك الإبقاء على معلوماتك محدَّثة قدر الإمكان حتى
                                            نتمكن من الاستمرار في تحسين خدمتنا لك.</p>
                                        <br>
                                        <p class="c-text">
                                            سنمنع وصولك إلى هذه المعلومات فقط في ظروف محدودة للغاية حيث يسمح القانون بذلك،
                                            مثل: <br>
                                        <ol style="padding-right: 150px; list-style-type: disc;">
                                            <li style="color: black; font-size: 25px;">حيثما قد يكون من الخطر حصولك عليها
                                            </li>
                                            <li style="color: black; font-size: 25px;">حيثما قد يضر تحقيقًا جاريًا</li>
                                            <li style="color: black; font-size: 25px;">عندما يتعلق الأمر بإجراءات محكمة وقد
                                                يخضع لعملية كشف</li>
                                            <li style="color: black; font-size: 25px;">حيثما قد يتعلق بعملية صنع القرار
                                                الحساسة تجاريًا</li>
                                            <li style="color: black; font-size: 25px;">حيثما يتم تضمين المعلومات الشخصية
                                                لأفراد آخرين في السجل نفسه</li>
                                        </ol>
                                        <br>
                                        </p>
                                        <p class="a-text">قد تحتفظ "إتمام" (ولكنها غير ملزمة بذلك) بمعلوماتك لمدة 7 سنوات من
                                            تاريخ آخر مرة قمت فيها بإدخالها.</p>
                                        <br>
                                        <h3 class="b-text">ج. الأمان</h3>
                                        <br>
                                        <p class="c-text">تبذل إتمام أقصى جهدها لحماية المعلومات التي يقدمها المستخدم وفق
                                            أفضل الممارسات، وتعمل على تشفير المعلومات والبيانات الحساسة التي يتعين الحفاظ
                                            على سريتها توافقًا مع المتطلبات النظامية.
                                            سيسعى "دفترة" إلى اتخاذ جميع الخطوات المعقولة للحفاظ على أمان أي معلومات نحتفظ
                                            بها عنك. إذ يتم تخزين معلوماتك على خوادم آمنة محمية في منشآت خاضعة للرقابة. لسوء
                                            الحظ، على الرغم من خصائص التكنولوجيا والأمان المذكورة أعلاه، لا يمكن ضمان أن
                                            يكون نقل البيانات عبر الإنترنت آمنًا بنسبة 100٪، لذلك لا يمكننا تقديم ضمان مطلق
                                            بأن المعلومات التي تقدمها لنا ستكون آمنة في جميع الأوقات، ولا يمكننا كذلك تحمل
                                            المسؤولية عن أي حدث ينشأ عن الوصول غير المصرح به إلى معلوماتك الشخصية. ولن يتحمل
                                            "دفترة" المسؤولية عن الأحداث الناشئة عن حصول أطراف ثالثة على وصول غير مصرح به
                                            إلى معلوماتك الشخصية.
                                            يرجى ملاحظة أيضًا أن "دفترة" قد يستخدم مرافق خارجية لمعالجة معلوماتها أو نسخها
                                            احتياطيًا. نتيجة لذلك، قد ننقل معلوماتك الشخصية ونخزنها في منشآتنا الخارجية. على
                                            الرغم من ذلك، فإن هذا لا يغير أيًا من التزاماتنا لحماية خصوصيتك.
                                        </p>
                                        <br>
                                        <h3 class="b-text">التغييرات على سياسة خصوصية "إتمام"</h3>
                                        <br>
                                        <p class="a-text">
                                            قد تقوم "إتمام" بالتعديل على سياسة الخصوصية هذه من وقت لآخر. إذا أجرينا أي
                                            تغييرات جوهرية بأي طريقة من الطرق التي نستخدم بها معلوماتك الشخصية، فسنخطرك عن
                                            طريق نشر إعلان بارز على صفحات الويب الخاصة بنا أو عن طريق البريد الإلكتروني
                                            وسيكون لديك خيار الموافقة على ما إذا كنا سنستخدم المعلومات بهذه الطريقة المختلفة
                                            أم لا.
                                        </p>
                                        <br>
                                        <p class="a-text">شكرًا لك على الوقت الذي استغرقته لفهم سياسة خصوصية "إتمام".</p>
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
                                1.who are we</h2>
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
                                <p class="a-text">Etmam is committed to the highest consumer standards to protect
                                    its users and those to whom it provides its services.</p> <br>
                                <p class="a-text">Etmam created this privacy policy with you in mind, and it is
                                    necessary that you have a comprehensive understanding of the methods of
                                    collecting and using information, taking into account that you are the first and
                                    last controller of your personal information provided to Etmam. After reading
                                    the privacy policy you will notice that using the completion web page:
                                    <br><br>
                                <ol class="ul-text" style="list-style-type: disc;">
                                    <li style="color: black; font-size: 25px;">You agree that if you disclose your
                                        personal information to us, we may create a database record about you.</li>
                                    <li style="color: black; font-size: 25px;">If you register on our website or
                                        download any materials or perform any other transactions, you agree that we
                                        may collect the necessary information to provide you with the requested
                                        service and that we may disclose this information to service partners (who
                                        may be third parties) for those purposes.</li>
                                    <li style="color: black; font-size: 25px;">You agree to the use of cookies on
                                        your browser (unless you choose to remove them).</li>
                                    <li style="color: black; font-size: 25px;">You agree that we may contact you to
                                        provide information about products and services that may interest you
                                        (unless you have stated that you do not wish to receive such
                                        communications).</li>
                                    <li style="color: black; font-size: 25px;">Your continued use of the "Etmaam"
                                        website on the web implies your consent to any future changes in the
                                        "Etmaam" privacy policy.</li>
                                </ol>
                                </p>
                                <br> <br>
                                <h2 style="color: #0A3041">2. What Information is Collected and How is it Used?
                                </h2>
                                <br>
                                <p class="a-text">"Etmaam" collects information from you at various points on the
                                    website:</p>
                                <br>
                                <h3 class="b-text">A. Service Request</h3>
                                <br>
                                <strong class="c-text">What information is collected?</strong> <br>
                                <p class="a-text">
                                <ol style="padding-left: 110px; list-style-type: disc;">
                                    <li style="color: black; font-size: 25px;">When requesting a service from
                                        Etmaam, you will be asked to provide your email, along with your phone
                                        number and full name, accompanied by the city you reside in (if you use the
                                        full form).</li>
                                    <li style="color: black; font-size: 25px;">Your IP address is also taken (your
                                        IP address is the number associated with the computer device you are using,
                                        which allows other devices connected to the internet to identify the
                                        destination of outgoing data, and collects some information such as the type
                                        of browser and search engine, but without identifying your personal
                                        identity).</li>
                                    <li style="color: black; font-size: 25px;">You are also given the option to
                                        register for regular updates and/or newsletters from "Etmaam" to inform you
                                        of the latest news and deals.</li>
                                </ol>
                                </p>
                                <br>
                                <strong class="c-text">Why do we collect this information?</strong>
                                <br>
                                <p class="c-text" style="padding-left: 120px">
                                    We collect the above-mentioned information for the following purposes:</p>
                                <br>
                                <ol style="padding-left: 140px; list-style-type: disc;">
                                    <li style="color: black; font-size: 25px;">To identify you when using our
                                        website for a personalized and customized experience.</li>
                                    <li style="color: black; font-size: 25px;">To provide you with a default screen
                                        plan based on the country you specify.</li>
                                    <li style="color: black; font-size: 25px;">As a security measure, to send you
                                        an email to confirm your account registration.</li>
                                    <li style="color: black; font-size: 25px;">To allow us to process and complete
                                        your services.</li>
                                    <li style="color: black; font-size: 25px;">To enable a seamless experience when
                                        making future order transactions.</li>
                                    <li style="color: black; font-size: 25px;">To send email confirmations for
                                        actions related to "Etmaam".</li>
                                    <li style="color: black; font-size: 25px;">To confirm your identity and
                                        authenticate it.</li>
                                    <li style="color: black; font-size: 25px;">For our customer service agents to
                                        contact you when necessary.</li>
                                    <li style="color: black; font-size: 25px;">To send our regular updates and/or
                                        newsletters to you optionally if you register for them.</li>
                                    <li style="color: black; font-size: 25px;">To send you information about
                                        products and services that may interest you.</li>
                                </ol>
                                <br>
                                <h3 class="b-text">B. Customer Communication</h3> <br>
                                <strong class="c-text">What information is collected?</strong> <br>
                                <p class="c-text" style="padding-left: 150px">You can choose to provide feedback
                                    to "Etmaam," for example, via email or messages. The comments you choose to
                                    submit may be retained in feedback, along with your contact information such as
                                    your email, if provided to "Etmaam," in records.</p><br>
                                <strong class="c-text">Why do we collect this information?</strong> <br>
                                <ol style="padding-left: 160px; list-style-type: disc;">
                                    <li style="color: black; font-size: 25px;">The feedback you choose to provide
                                        is valuable to assist "Etmaam" in making improvements to our service
                                        provided to you. To follow up on the feedback you chose to submit, "Etmaam"
                                        may contact you using the provided contact information.</li>
                                    <li style="color: black; font-size: 25px;">To send you information about
                                        products and services that may interest you.</li>
                                </ol>
                                <br>
                                <h3 class="b-text">C. Cookies</h3> <br>
                                <strong class="c-text">What information is collected?</strong> <br>
                                <p class="c-text" style="padding-left: 170px;">
                                    When visiting the "Etmaam" website, a cookie is stored on your computer (a
                                    cookie is a small, encrypted text file containing some information about your
                                    preferences and allows tracking of your usage), and the use of cookies is now an
                                    industry standard, and you will find them used on most major websites. However,
                                    you can always choose to disable storing cookies on your computer by changing
                                    your browser settings. Disabling cookies may result in limited functionality of
                                    our features and services, and in some cases, it may mean that we are unable to
                                    provide you with the services or parts of the services you requested. Cookies
                                    may also be used by some of our business partners whose content is integrated
                                    into our site or associated with it. However, we do not have access to or
                                    control over these cookies.
                                </p>

                                <br>
                                <strong class="c-text">Why do we collect this information?</strong> <br>
                                <p class="c-text">Cookies, when stored on your computer, facilitate the following:
                                    <br>
                                <ol class="c-text" style="padding-left: 150px; list-style-type: disc;">
                                    <li>Allow us to save passwords and preferences on your behalf so you don't have
                                        to re-enter them the next time you visit us. This means you can have a more
                                        convenient experience.</li>
                                    <li>"Etmaam" can make improvements to the site based on aggregated usage
                                        statistics collected from cookies. These aggregated usage statistics are
                                        anonymous to third parties and can also be used by third-party advertising
                                        companies related to "Etmaam" to monitor the effectiveness of
                                        advertisements.</li>
                                </ol>
                                </p>
                                <h2 style="color:#0A3041; ">3. Your Personal Control of Information</h2>
                                <br>
                                <h3 class="b-text">A. Subscription and Unsubscription Policy</h3>
                                <br>
                                <p class="c-text">You always have the option to subscribe to participate in
                                    "Etmaam" product and service offers. For example, you will be given the option
                                    to subscribe to the "Etmaam" newsletter by clicking the checkbox.
                                    While "Etmaam" values your participation in our product and service offers, at
                                    any time, you always have the option to unsubscribe from the products and
                                    services you have subscribed to.
                                    We provide you with the ability to unsubscribe from receiving information about
                                    our products and services at the information collection stage or by accessing
                                    your account information and making changes. Please allow some time for
                                    processing this request.</p>
                                <br>
                                <h3 class="b-text">B. Access to Your Information and Data Retention</h3>
                                <br>
                                <p class="c-text">Although we will take reasonable steps to maintain the accuracy,
                                    completeness, and updating of your information, we request that you keep your
                                    information as up-to-date as possible so that we can continue to improve our
                                    service to you.</p>
                                <br>
                                <p class="c-text">We will restrict your access to this information only in
                                    extremely limited circumstances where the law permits, such as:</p>
                                <br>
                                <ol style="padding-left: 150px; list-style-type: disc;">
                                    <li style="color: black; font-size: 25px;">Where it may be dangerous for you to
                                        obtain it.</li>
                                    <li style="color: black; font-size: 25px;">Where it may harm an ongoing
                                        investigation.</li>
                                    <li style="color: black; font-size: 25px;">When it concerns court proceedings
                                        and may be subject to disclosure.</li>
                                    <li style="color: black; font-size: 25px;">Where it relates to sensitive
                                        commercial decision-making.</li>
                                    <li style="color: black; font-size: 25px;">Where personal information of others
                                        is included in the same record.</li>
                                </ol>
                                <br>
                                <p class="a-text">"Etmaam" may retain (but is not obligated to) your information
                                    for a period of 7 years from the date of your last entry.</p>
                                <br>
                                <h3 class="b-text">C. Security</h3>

                                <br>
                                <p class="c-text">Etmaam makes every effort to protect the information provided by
                                    the user in accordance with best practices, and works to encrypt sensitive
                                    information and data that must be kept confidential in compliance with
                                    regulatory requirements.
                                    Etmaam will seek to take all reasonable steps to maintain the security of any
                                    information we retain about you. Your information is stored on secure, monitored
                                    facilities. Unfortunately, despite the technology and security features
                                    mentioned above, no data transmission over the internet can be guaranteed to be
                                    100% secure, so we cannot provide an absolute guarantee that the information you
                                    provide to us will be secure at all times. We also cannot be responsible for any
                                    event arising from unauthorized access to your personal information. Etmaam will
                                    not be responsible for events resulting from third parties gaining unauthorized
                                    access to your personal information.
                                    Please also note that Etmaam may use external facilities to process or back up
                                    its information. As a result, we may transfer and store your personal
                                    information in our external facilities. However, this does not change any of our
                                    commitments to protect your privacy.</p>
                                <br>
                                <h3 class="b-text">Changes to the "Etmaam" Privacy Policy</h3>
                                <br>
                                <p class="a-text">
                                    "Etmaam" may modify this privacy policy from time to time. If we make any
                                    significant changes in the way we use your personal information, we will notify
                                    you by prominently posting an announcement on our webpages or by email, and you
                                    will have the option to consent to whether we will use the information in this
                                    different way or not.
                                </p>
                                <br>
                                <p class="a-text">Thank you for taking the time to understand the "Etmaam" Privacy
                                    Policy.</p>
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
