/**
 * Usage:
 *
 * grunt --project=Avada --locale=es_ES       // Compile es_ES in Avada.
 * grunt --project=fusion-builder --locale=el // Compile es_ES in fusion-builder.
 * grunt --project=fusion-core                // Compile all languages in fusion-core.
 * grunt --locale=es_ES                       // Compile es_ES on all projects.
 * grunt                                      // Compile all languages on all projects.
 */
module.exports = function( grunt ) {

	var project = grunt.option( 'project' ) || 'all';
	var locale = grunt.option( 'locale' ) || 'all';
	var poFilesPath;
	var projects = [ 'Avada', 'fusion-core', 'fusion-builder', 'fusion-white-label-branding' ];

	/**
	 * An object containing the languages.
	 * JSON derived from http://api.wordpress.org/translations/core/1.0/
	 */
	var langs = [{"language":"af","english_name":"Afrikaans","native_name":"Afrikaans","iso":{"1":"af","2":"afr"},"strings":{"continue":"Gaan voort"}},{"language":"ar","english_name":"Arabic","native_name":"\u0627\u0644\u0639\u0631\u0628\u064a\u0629","iso":{"1":"ar","2":"ara"},"strings":{"continue":"\u0627\u0644\u0645\u062a\u0627\u0628\u0639\u0629"}},{"language":"ary","english_name":"Moroccan Arabic","native_name":"\u0627\u0644\u0639\u0631\u0628\u064a\u0629 \u0627\u0644\u0645\u063a\u0631\u0628\u064a\u0629","iso":{"1":"ar","3":"ary"},"strings":{"continue":"\u0627\u0644\u0645\u062a\u0627\u0628\u0639\u0629"}},{"language":"as","english_name":"Assamese","native_name":"\u0985\u09b8\u09ae\u09c0\u09af\u09bc\u09be","iso":{"1":"as","2":"asm","3":"asm"},"strings":{"continue":""}},{"language":"az","english_name":"Azerbaijani","native_name":"Az\u0259rbaycan dili","iso":{"1":"az","2":"aze"},"strings":{"continue":"Davam"}},{"language":"azb","english_name":"South Azerbaijani","native_name":"\u06af\u0624\u0646\u0626\u06cc \u0622\u0630\u0631\u0628\u0627\u06cc\u062c\u0627\u0646","iso":{"1":"az","3":"azb"},"strings":{"continue":"Continue"}},{"language":"bel","english_name":"Belarusian","native_name":"\u0411\u0435\u043b\u0430\u0440\u0443\u0441\u043a\u0430\u044f \u043c\u043e\u0432\u0430","iso":{"1":"be","2":"bel"},"strings":{"continue":"\u041f\u0440\u0430\u0446\u044f\u0433\u043d\u0443\u0446\u044c"}},{"language":"bg_BG","english_name":"Bulgarian","native_name":"\u0411\u044a\u043b\u0433\u0430\u0440\u0441\u043a\u0438","iso":{"1":"bg","2":"bul"},"strings":{"continue":"\u041f\u0440\u043e\u0434\u044a\u043b\u0436\u0435\u043d\u0438\u0435"}},{"language":"bn_BD","english_name":"Bengali (Bangladesh)","native_name":"\u09ac\u09be\u0982\u09b2\u09be","iso":{"1":"bn"},"strings":{"continue":"\u098f\u0997\u09bf\u09df\u09c7 \u099a\u09b2."}},{"language":"bo","english_name":"Tibetan","native_name":"\u0f56\u0f7c\u0f51\u0f0b\u0f61\u0f72\u0f42","iso":{"1":"bo","2":"tib"},"strings":{"continue":"\u0f58\u0f74\u0f0b\u0f58\u0f50\u0f74\u0f51\u0f0d"}},{"language":"bs_BA","english_name":"Bosnian","native_name":"Bosanski","iso":{"1":"bs","2":"bos"},"strings":{"continue":"Nastavi"}},{"language":"ca","english_name":"Catalan","native_name":"Catal\u00e0","iso":{"1":"ca","2":"cat"},"strings":{"continue":"Continua"}},{"language":"ceb","english_name":"Cebuano","native_name":"Cebuano","iso":{"2":"ceb","3":"ceb"},"strings":{"continue":"Padayun"}},{"language":"cs_CZ","english_name":"Czech","native_name":"\u010ce\u0161tina","iso":{"1":"cs","2":"ces"},"strings":{"continue":"Pokra\u010dovat"}},{"language":"cy","english_name":"Welsh","native_name":"Cymraeg","iso":{"1":"cy","2":"cym"},"strings":{"continue":"Parhau"}},{"language":"da_DK","english_name":"Danish","native_name":"Dansk","iso":{"1":"da","2":"dan"},"strings":{"continue":"Fortsæt"}},{"language":"de_CH_informal","english_name":"German (Switzerland, Informal)","native_name":"Deutsch (Schweiz, Du)","iso":{"1":"de"},"strings":{"continue":"Weiter"}},{"language":"de_DE","english_name":"German","native_name":"Deutsch","iso":{"1":"de"},"strings":{"continue":"Fortfahren"}},{"language":"de_DE_formal","english_name":"German (Formal)","native_name":"Deutsch (Sie)","iso":{"1":"de"},"strings":{"continue":"Fortfahren"}},{"language":"de_AT","english_name":"German (Austria)","native_name":"Deutsch (\u00d6sterreich)","iso":{"1":"de"},"strings":{"continue":"Weiter"}},{"language":"de_CH","english_name":"German (Switzerland)","native_name":"Deutsch (Schweiz)","iso":{"1":"de"},"strings":{"continue":"Fortfahren"}},{"language":"dzo","english_name":"Dzongkha","native_name":"\u0f62\u0fab\u0f7c\u0f44\u0f0b\u0f41","iso":{"1":"dz","2":"dzo"},"strings":{"continue":""}},{"language":"el","english_name":"Greek","native_name":"\u0395\u03bb\u03bb\u03b7\u03bd\u03b9\u03ba\u03ac","iso":{"1":"el","2":"ell"},"strings":{"continue":"\u03a3\u03c5\u03bd\u03ad\u03c7\u03b5\u03b9\u03b1"}},{"language":"en_AU","english_name":"English (Australia)","native_name":"English (Australia)","iso":{"1":"en","2":"eng","3":"eng"},"strings":{"continue":"Continue"}},{"language":"en_ZA","english_name":"English (South Africa)","native_name":"English (South Africa)","iso":{"1":"en","2":"eng","3":"eng"},"strings":{"continue":"Continue"}},{"language":"en_GB","english_name":"English (UK)","native_name":"English (UK)","iso":{"1":"en","2":"eng","3":"eng"},"strings":{"continue":"Continue"}},{"language":"en_CA","english_name":"English (Canada)","native_name":"English (Canada)","iso":{"1":"en","2":"eng","3":"eng"},"strings":{"continue":"Continue"}},{"language":"en_NZ","english_name":"English (New Zealand)","native_name":"English (New Zealand)","iso":{"1":"en","2":"eng","3":"eng"},"strings":{"continue":"Continue"}},{"language":"en_US","english_name":"English (US)","native_name":"English (US)","iso":{"1":"en","2":"eng","3":"eng"},"strings":{"continue":"Continue"}},{"language":"eo","english_name":"Esperanto","native_name":"Esperanto","iso":{"1":"eo","2":"epo"},"strings":{"continue":"Da\u016drigi"}},{"language":"es_AR","english_name":"Spanish (Argentina)","native_name":"Espa\u00f1ol de Argentina","iso":{"1":"es","2":"spa","3":"spa"},"strings":{"continue":"Continuar"}},{"language":"es_ES","english_name":"Spanish (Spain)","native_name":"Espa\u00f1ol","iso":{"1":"es","2":"spa","3":"spa"},"strings":{"continue":"Continuar"}},{"language":"es_VE","english_name":"Spanish (Venezuela)","native_name":"Espa\u00f1ol de Venezuela","iso":{"1":"es","2":"spa","3":"spa"},"strings":{"continue":"Continuar"}},{"language":"es_GT","english_name":"Spanish (Guatemala)","native_name":"Espa\u00f1ol de Guatemala","iso":{"1":"es","2":"spa","3":"spa"},"strings":{"continue":"Continuar"}},{"language":"es_MX","english_name":"Spanish (Mexico)","native_name":"Espa\u00f1ol de M\u00e9xico","iso":{"1":"es","2":"spa","3":"spa"},"strings":{"continue":"Continuar"}},{"language":"es_CR","english_name":"Spanish (Costa Rica)","native_name":"Espa\u00f1ol de Costa Rica","iso":{"1":"es","2":"spa","3":"spa"},"strings":{"continue":"Continuar"}},{"language":"es_CO","english_name":"Spanish (Colombia)","native_name":"Espa\u00f1ol de Colombia","iso":{"1":"es","2":"spa","3":"spa"},"strings":{"continue":"Continuar"}},{"language":"es_PE","english_name":"Spanish (Peru)","native_name":"Espa\u00f1ol de Per\u00fa","iso":{"1":"es","2":"spa","3":"spa"},"strings":{"continue":"Continuar"}},{"language":"es_CL","english_name":"Spanish (Chile)","native_name":"Espa\u00f1ol de Chile","iso":{"1":"es","2":"spa","3":"spa"},"strings":{"continue":"Continuar"}},{"language":"et","english_name":"Estonian","native_name":"Eesti","iso":{"1":"et","2":"est"},"strings":{"continue":"J\u00e4tka"}},{"language":"eu","english_name":"Basque","native_name":"Euskara","iso":{"1":"eu","2":"eus"},"strings":{"continue":"Jarraitu"}},{"language":"fa_IR","english_name":"Persian","native_name":"\u0641\u0627\u0631\u0633\u06cc","iso":{"1":"fa","2":"fas"},"strings":{"continue":"\u0627\u062f\u0627\u0645\u0647"}},{"language":"fi","english_name":"Finnish","native_name":"Suomi","iso":{"1":"fi","2":"fin"},"strings":{"continue":"Jatka"}},{"language":"fr_FR","english_name":"French (France)","native_name":"Fran\u00e7ais","iso":{"1":"fr"},"strings":{"continue":"Continuer"}},{"language":"fr_CA","english_name":"French (Canada)","native_name":"Fran\u00e7ais du Canada","iso":{"1":"fr","2":"fra"},"strings":{"continue":"Continuer"}},{"language":"fr_BE","english_name":"French (Belgium)","native_name":"Fran\u00e7ais de Belgique","iso":{"1":"fr","2":"fra"},"strings":{"continue":"Continuer"}},{"language":"fur","english_name":"Friulian","native_name":"Friulian","iso":{"2":"fur","3":"fur"},"strings":{"continue":"Continue"}},{"language":"gd","english_name":"Scottish Gaelic","native_name":"G\u00e0idhlig","iso":{"1":"gd","2":"gla","3":"gla"},"strings":{"continue":"Lean air adhart"}},{"language":"gl_ES","english_name":"Galician","native_name":"Galego","iso":{"1":"gl","2":"glg"},"strings":{"continue":"Continuar"}},{"language":"gu","english_name":"Gujarati","native_name":"\u0a97\u0ac1\u0a9c\u0ab0\u0abe\u0aa4\u0ac0","iso":{"1":"gu","2":"guj"},"strings":{"continue":"\u0a9a\u0abe\u0ab2\u0ac1 \u0ab0\u0abe\u0a96\u0ab5\u0ac1\u0a82"}},{"language":"haz","english_name":"Hazaragi","native_name":"\u0647\u0632\u0627\u0631\u0647 \u06af\u06cc","iso":{"3":"haz"},"strings":{"continue":"\u0627\u062f\u0627\u0645\u0647"}},{"language":"he_IL","english_name":"Hebrew","native_name":"\u05e2\u05b4\u05d1\u05b0\u05e8\u05b4\u05d9\u05ea","iso":{"1":"he"},"strings":{"continue":"\u05dc\u05d4\u05de\u05e9\u05d9\u05da"}},{"language":"hi_IN","english_name":"Hindi","native_name":"\u0939\u093f\u0928\u094d\u0926\u0940","iso":{"1":"hi","2":"hin"},"strings":{"continue":"\u091c\u093e\u0930\u0940"}},{"language":"hr","english_name":"Croatian","native_name":"Hrvatski","iso":{"1":"hr","2":"hrv"},"strings":{"continue":"Nastavi"}},{"language":"hu_HU","english_name":"Hungarian","native_name":"Magyar","iso":{"1":"hu","2":"hun"},"strings":{"continue":"Tov\u00e1bb"}},{"language":"hy","english_name":"Armenian","native_name":"\u0540\u0561\u0575\u0565\u0580\u0565\u0576","iso":{"1":"hy","2":"hye"},"strings":{"continue":"\u0547\u0561\u0580\u0578\u0582\u0576\u0561\u056f\u0565\u056c"}},{"language":"id_ID","english_name":"Indonesian","native_name":"Bahasa Indonesia","iso":{"1":"id","2":"ind"},"strings":{"continue":"Lanjutkan"}},{"language":"is_IS","english_name":"Icelandic","native_name":"\u00cdslenska","iso":{"1":"is","2":"isl"},"strings":{"continue":"\u00c1fram"}},{"language":"it_IT","english_name":"Italian","native_name":"Italiano","iso":{"1":"it","2":"ita"},"strings":{"continue":"Continua"}},{"language":"ja","english_name":"Japanese","native_name":"\u65e5\u672c\u8a9e","iso":{"1":"ja"},"strings":{"continue":"\u7d9a\u3051\u308b"}},{"language":"jv_ID","english_name":"Javanese","native_name":"Basa Jawa","iso":{"1":"jv","2":"jav"},"strings":{"continue":"Nutugne"}},{"language":"ka_GE","english_name":"Georgian","native_name":"\u10e5\u10d0\u10e0\u10d7\u10e3\u10da\u10d8","iso":{"1":"ka","2":"kat"},"strings":{"continue":"\u10d2\u10d0\u10d2\u10e0\u10eb\u10d4\u10da\u10d4\u10d1\u10d0"}},{"language":"kab","english_name":"Kabyle","native_name":"Taqbaylit","iso":{"2":"kab","3":"kab"},"strings":{"continue":"Continuer"}},{"language":"kk","english_name":"Kazakh","native_name":"\u049a\u0430\u0437\u0430\u049b \u0442\u0456\u043b\u0456","iso":{"1":"kk","2":"kaz"},"strings":{"continue":"\u0416\u0430\u043b\u0493\u0430\u0441\u0442\u044b\u0440\u0443"}},{"language":"km","english_name":"Khmer","native_name":"\u1797\u17b6\u179f\u17b6\u1781\u17d2\u1798\u17c2\u179a","iso":{"1":"km","2":"khm"},"strings":{"continue":"\u1794\u1793\u17d2\u178f"}},{"language":"kn","english_name":"Kannada","native_name":"\u0c95\u0ca8\u0ccd\u0ca8\u0ca1","iso":{"1":"kn","2":"kan"},"strings":{"continue":"\u0cae\u0cc1\u0c82\u0ca6\u0cc1\u0cb5\u0cb0\u0cc6\u0cb8\u0cbf"}},{"language":"ko_KR","english_name":"Korean","native_name":"\ud55c\uad6d\uc5b4","iso":{"1":"ko","2":"kor"},"strings":{"continue":"\uacc4\uc18d"}},{"language":"ckb","english_name":"Kurdish (Sorani)","native_name":"\u0643\u0648\u0631\u062f\u06cc\u200e","iso":{"1":"ku","3":"ckb"},"strings":{"continue":"\u0628\u0647\u200c\u0631\u062f\u0647\u200c\u0648\u0627\u0645 \u0628\u0647\u200c"}},{"language":"lo","english_name":"Lao","native_name":"\u0e9e\u0eb2\u0eaa\u0eb2\u0ea5\u0eb2\u0ea7","iso":{"1":"lo","2":"lao"},"strings":{"continue":"\u0e95\u0ecd\u0ec8"}},{"language":"lt_LT","english_name":"Lithuanian","native_name":"Lietuvi\u0173 kalba","iso":{"1":"lt","2":"lit"},"strings":{"continue":"T\u0119sti"}},{"language":"lv","english_name":"Latvian","native_name":"Latvie\u0161u valoda","iso":{"1":"lv","2":"lav"},"strings":{"continue":"Turpin\u0101t"}},{"language":"mk_MK","english_name":"Macedonian","native_name":"\u041c\u0430\u043a\u0435\u0434\u043e\u043d\u0441\u043a\u0438 \u0458\u0430\u0437\u0438\u043a","iso":{"1":"mk","2":"mkd"},"strings":{"continue":"\u041f\u0440\u043e\u0434\u043e\u043b\u0436\u0438"}},{"language":"ml_IN","english_name":"Malayalam","native_name":"\u0d2e\u0d32\u0d2f\u0d3e\u0d33\u0d02","iso":{"1":"ml","2":"mal"},"strings":{"continue":"\u0d24\u0d41\u0d1f\u0d30\u0d41\u0d15"}},{"language":"mn","english_name":"Mongolian","native_name":"\u041c\u043e\u043d\u0433\u043e\u043b","iso":{"1":"mn","2":"mon"},"strings":{"continue":"\u04ae\u0440\u0433\u044d\u043b\u0436\u043b\u04af\u04af\u043b\u044d\u0445"}},{"language":"mr","english_name":"Marathi","native_name":"\u092e\u0930\u093e\u0920\u0940","iso":{"1":"mr","2":"mar"},"strings":{"continue":"\u0938\u0941\u0930\u0941 \u0920\u0947\u0935\u093e"}},{"language":"ms_MY","english_name":"Malay","native_name":"Bahasa Melayu","iso":{"1":"ms","2":"msa"},"strings":{"continue":"Teruskan"}},{"language":"my_MM","english_name":"Myanmar (Burmese)","native_name":"\u1017\u1019\u102c\u1005\u102c","iso":{"1":"my","2":"mya"},"strings":{"continue":"\u1006\u1000\u103a\u101c\u1000\u103a\u101c\u102f\u1015\u103a\u1031\u1006\u102c\u1004\u103a\u1015\u102b\u104b"}},{"language":"nb_NO","english_name":"Norwegian (Bokm\u00e5l)","native_name":"Norsk bokm\u00e5l","iso":{"1":"nb","2":"nob"},"strings":{"continue":"Fortsett"}},{"language":"ne_NP","english_name":"Nepali","native_name":"\u0928\u0947\u092a\u093e\u0932\u0940","iso":{"1":"ne","2":"nep"},"strings":{"continue":"\u091c\u093e\u0930\u0940\u0930\u093e\u0916\u094d\u0928\u0941 "}},{"language":"nl_BE","english_name":"Dutch (Belgium)","native_name":"Nederlands (Belgi\u00eb)","iso":{"1":"nl","2":"nld"},"strings":{"continue":"Doorgaan"}},{"language":"nl_NL","english_name":"Dutch","native_name":"Nederlands","iso":{"1":"nl","2":"nld"},"strings":{"continue":"Doorgaan"}},{"language":"nl_NL_formal","english_name":"Dutch (Formal)","native_name":"Nederlands (Formeel)","iso":{"1":"nl","2":"nld"},"strings":{"continue":"Doorgaan"}},{"language":"nn_NO","english_name":"Norwegian (Nynorsk)","native_name":"Norsk nynorsk","iso":{"1":"nn","2":"nno"},"strings":{"continue":"Hald fram"}},{"language":"oci","english_name":"Occitan","native_name":"Occitan","iso":{"1":"oc","2":"oci"},"strings":{"continue":"Contunhar"}},{"language":"pa_IN","english_name":"Punjabi","native_name":"\u0a2a\u0a70\u0a1c\u0a3e\u0a2c\u0a40","iso":{"1":"pa","2":"pan"},"strings":{"continue":"\u0a1c\u0a3e\u0a30\u0a40 \u0a30\u0a71\u0a16\u0a4b"}},{"language":"pl_PL","english_name":"Polish","native_name":"Polski","iso":{"1":"pl","2":"pol"},"strings":{"continue":"Kontynuuj"}},{"language":"ps","english_name":"Pashto","native_name":"\u067e\u069a\u062a\u0648","iso":{"1":"ps","2":"pus"},"strings":{"continue":"\u062f\u0648\u0627\u0645"}},{"language":"pt_BR","english_name":"Portuguese (Brazil)","native_name":"Portugu\u00eas do Brasil","iso":{"1":"pt","2":"por"},"strings":{"continue":"Continuar"}},{"language":"pt_PT_ao90","english_name":"Portuguese (Portugal, AO90)","native_name":"Portugu\u00eas (AO90)","iso":{"1":"pt"},"strings":{"continue":"Continuar"}},{"language":"pt_PT","english_name":"Portuguese (Portugal)","native_name":"Portugu\u00eas","iso":{"1":"pt"},"strings":{"continue":"Continuar"}},{"language":"pt_AO","english_name":"Portuguese (Angola)","native_name":"Portugu\u00eas de Angola","iso":{"1":"pt"},"strings":{"continue":"Continuar"}},{"language":"rhg","english_name":"Rohingya","native_name":"Ru\u00e1inga","iso":{"3":"rhg"},"strings":{"continue":""}},{"language":"ro_RO","english_name":"Romanian","native_name":"Rom\u00e2n\u0103","iso":{"1":"ro","2":"ron"},"strings":{"continue":"Continu\u0103"}},{"language":"ru_RU","english_name":"Russian","native_name":"\u0420\u0443\u0441\u0441\u043a\u0438\u0439","iso":{"1":"ru","2":"rus"},"strings":{"continue":"\u041f\u0440\u043e\u0434\u043e\u043b\u0436\u0438\u0442\u044c"}},{"language":"sah","english_name":"Sakha","native_name":"\u0421\u0430\u0445\u0430\u043b\u044b\u044b","iso":{"2":"sah","3":"sah"},"strings":{"continue":"\u0421\u0430\u043b\u0495\u0430\u0430"}},{"language":"si_LK","english_name":"Sinhala","native_name":"\u0dc3\u0dd2\u0d82\u0dc4\u0dbd","iso":{"1":"si","2":"sin"},"strings":{"continue":"\u0daf\u0dd2\u0d9c\u0da7\u0db8 \u0d9a\u0dbb\u0d9c\u0dd9\u0db1 \u0dba\u0db1\u0dca\u0db1"}},{"language":"sk_SK","english_name":"Slovak","native_name":"Sloven\u010dina","iso":{"1":"sk","2":"slk"},"strings":{"continue":"Pokra\u010dova\u0165"}},{"language":"skr","english_name":"Saraiki","native_name":"\u0633\u0631\u0627\u0626\u06cc\u06a9\u06cc","iso":{"3":"skr"},"strings":{"continue":"\u062c\u0627\u0631\u06cc \u0631\u06a9\u06be\u0648"}},{"language":"sl_SI","english_name":"Slovenian","native_name":"Sloven\u0161\u010dina","iso":{"1":"sl","2":"slv"},"strings":{"continue":"Nadaljujte"}},{"language":"sq","english_name":"Albanian","native_name":"Shqip","iso":{"1":"sq","2":"sqi"},"strings":{"continue":"Vazhdo"}},{"language":"sr_RS","english_name":"Serbian","native_name":"\u0421\u0440\u043f\u0441\u043a\u0438 \u0458\u0435\u0437\u0438\u043a","iso":{"1":"sr","2":"srp"},"strings":{"continue":"\u041d\u0430\u0441\u0442\u0430\u0432\u0438"}},{"language":"sv_SE","english_name":"Swedish","native_name":"Svenska","iso":{"1":"sv","2":"swe"},"strings":{"continue":"Forts\u00e4tt"}},{"language":"szl","english_name":"Silesian","native_name":"\u015al\u014dnsk\u014f g\u014fdka","iso":{"3":"szl"},"strings":{"continue":"K\u014dntynuowa\u0107"}},{"language":"ta_IN","english_name":"Tamil","native_name":"\u0ba4\u0bae\u0bbf\u0bb4\u0bcd","iso":{"1":"ta","2":"tam"},"strings":{"continue":"\u0ba4\u0bca\u0b9f\u0bb0\u0bb5\u0bc1\u0bae\u0bcd"}},{"language":"te","english_name":"Telugu","native_name":"\u0c24\u0c46\u0c32\u0c41\u0c17\u0c41","iso":{"1":"te","2":"tel"},"strings":{"continue":"\u0c15\u0c4a\u0c28\u0c38\u0c3e\u0c17\u0c3f\u0c02\u0c1a\u0c41"}},{"language":"th","english_name":"Thai","native_name":"\u0e44\u0e17\u0e22","iso":{"1":"th","2":"tha"},"strings":{"continue":"\u0e15\u0e48\u0e2d\u0e44\u0e1b"}},{"language":"tl","english_name":"Tagalog","native_name":"Tagalog","iso":{"1":"tl","2":"tgl"},"strings":{"continue":"Magpatuloy"}},{"language":"tr_TR","english_name":"Turkish","native_name":"T\u00fcrk\u00e7e","iso":{"1":"tr","2":"tur"},"strings":{"continue":"Devam"}},{"language":"tt_RU","english_name":"Tatar","native_name":"\u0422\u0430\u0442\u0430\u0440 \u0442\u0435\u043b\u0435","iso":{"1":"tt","2":"tat"},"strings":{"continue":"\u0434\u04d9\u0432\u0430\u043c \u0438\u0442\u04af"}},{"language":"tah","english_name":"Tahitian","native_name":"Reo Tahiti","iso":{"1":"ty","2":"tah","3":"tah"},"strings":{"continue":""}},{"language":"ug_CN","english_name":"Uighur","native_name":"\u0626\u06c7\u064a\u063a\u06c7\u0631\u0686\u06d5","iso":{"1":"ug","2":"uig"},"strings":{"continue":"\u062f\u0627\u06cb\u0627\u0645\u0644\u0627\u0634\u062a\u06c7\u0631\u06c7\u0634"}},{"language":"uk","english_name":"Ukrainian","native_name":"\u0423\u043a\u0440\u0430\u0457\u043d\u0441\u044c\u043a\u0430","iso":{"1":"uk","2":"ukr"},"strings":{"continue":"\u041f\u0440\u043e\u0434\u043e\u0432\u0436\u0438\u0442\u0438"}},{"language":"ur","english_name":"Urdu","native_name":"\u0627\u0631\u062f\u0648","iso":{"1":"ur","2":"urd"},"strings":{"continue":"\u062c\u0627\u0631\u06cc \u0631\u06a9\u06be\u06cc\u06ba"}},{"language":"uz_UZ","english_name":"Uzbek","native_name":"O\u2018zbekcha","iso":{"1":"uz","2":"uzb"},"strings":{"continue":"\u041f\u0440\u043e\u0434\u043e\u043b\u0436\u0438\u0442\u044c"}},{"language":"vi","english_name":"Vietnamese","native_name":"Ti\u1ebfng Vi\u1ec7t","iso":{"1":"vi","2":"vie"},"strings":{"continue":"Ti\u1ebfp t\u1ee5c"}},{"language":"zh_HK","english_name":"Chinese (Hong Kong)","native_name":"\u9999\u6e2f\u4e2d\u6587\u7248\t","iso":{"1":"zh","2":"zho"},"strings":{"continue":"\u7e7c\u7e8c"}},{"language":"zh_CN","english_name":"Chinese (China)","native_name":"\u7b80\u4f53\u4e2d\u6587","iso":{"1":"zh","2":"zho"},"strings":{"continue":"\u7ee7\u7eed"}},{"language":"zh_TW","english_name":"Chinese (Taiwan)","native_name":"\u7e41\u9ad4\u4e2d\u6587","iso":{"1":"zh","2":"zho"},"strings":{"continue":"\u7e7c\u7e8c"}}];

	// Build a simple array of language codes.
	var langCodes = [];
	for ( var i = 0; i < langs.length; i++ ) {
		if ( langs[ i ].language && '' !== langs[ i ].language ) {
			langCodes.push( langs[ i ].language );
		}
	}

	initConfig = {};

	// Merge language files.
	initConfig.msgInitMerge = {};
	projects.forEach( function( projectName ) {
		if ( 'all' === project || projectName === project ) {
			poFilesPath = ( 'all' === locale ) ? projectName + '/' + projectName + '-<%= locale%>.po' : projectName + '/' + projectName + '-' + locale + '.po';
			initConfig.msgInitMerge[ projectName ] = {
				src: [ projectName + '/' + projectName + '.pot'],
				options: {
					locales: langCodes,
					poFilesPath: poFilesPath,
					msgInit: {
						cmd: 'msginit',
						opts: {}
					},
					msgMerge: {
						cmd: 'msgmerge',
						opts: {
							'no-fuzzy-matching': true,
							'backup': 'none'
						}
					}
				}
			};
		}
	});

	// Compile .po files to .mo.
	initConfig.potomo = {};
	projects.forEach( function( projectName ) {
		if ( 'all' === project || projectName === project ) {
			initConfig.potomo[ projectName ] = {
				options: { poDel: false },
				files: [{
					expand: true,
					cwd: projectName,
					src: 'all' === locale ? ['*.po'] : [ projectName + '-' + locale + '.po' ],
					dest: projectName,
					ext: '.mo',
					nonull: true
				}]
			};
		}
	});

	// Config for ZIP files.
	initConfig.compress = {}
	projects.forEach( function( projectName ) {
		for ( var l = 0; l < langs.length; l++ ) {
			if ( 'all' === project || projectName === project ) {
				if ( 'all' === locale || langs[ l ].language === locale ) {
					initConfig.compress[ projectName + '_' + langs[ l ].language ] = {
						options: {
							archive: projectName + '/' + projectName + '-' + langs[ l ].language + '.zip'
						},
						files: [
							{
								expand: true,
								flatten: true,
								src: [
									projectName + '/' + projectName + '-' + langs[ l ].language + '.po',
									projectName + '/' + projectName + '-' + langs[ l ].language + '.mo'
								],
								dest: '/',
								filter: 'isFile'
							}
						]
					};
				}
			}
		}
	});

	// Project configuration.
	grunt.initConfig( initConfig );

	grunt.loadNpmTasks( 'grunt-potomo' );
	grunt.loadNpmTasks( 'grunt-msg-init-merge' );
	grunt.loadNpmTasks( 'grunt-contrib-compress' );

	grunt.registerTask( 'createJSON', function() {
		var json,
			date   = new Date(),
			year   = date.getUTCFullYear().toString(),
			month  = ( date.getUTCMonth() + 1 ).toString(), // Month starts from 0, not 1.
			day    = date.getUTCDate().toString(),
			hour   = date.getUTCHours().toString(),
			minute = date.getUTCMinutes().toString(),
			second = date.getUTCSeconds().toString(),
			productVersion;

		// 2-digits formatting.
		month  = ( 1 === month.length ) ? '0' + month : month;
		day    = ( 1 === day.length ) ? '0' + day : day;
		hour   = ( 1 === hour.length ) ? '0' + hour : hour;
		minute = ( 1 === minute.length ) ? '0' + minute : minute;
		second = ( 1 === second.length ) ? '0' + second : second;

		projects.forEach( function( projectName ) {
			var json = ( 'all' === locale ) ? {
				translations: langs
			} : JSON.parse( grunt.file.read( 'api-' + projectName + '.json' ) );

			if ( 'all' === project || projectName === project ) {

				// Get the product version from the .pot files.
				productVersion = grunt.file.read( projectName + '/' + projectName + '.pot' )
					.split( 'Project-Id-Version:' )[1]
					.split( '\\n"' )[0]
					.replace( 'Avada', '' )
					.replace( 'Fusion Builder', '' )
					.replace( 'Fusion Core', '' )
					.replace( 'Fusion White Label Branding', '' )
					.trim();

				for ( var i = 0; i < langs.length; i++ ) {
					if ( 'all' === locale || langs[ i ].language === locale ) {
						json.translations[ i ].version = productVersion;
						json.translations[ i ].updated = year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' + second;
						json.translations[ i ].package = 'https://raw.githubusercontent.com/Theme-Fusion/Localization-l10n/master/' + projectName + '/' + projectName + '-' + langs[ i ].language + '.zip';
					}
				}
				grunt.file.write( 'api-' + projectName + '.json', JSON.stringify( json ) );
			}
		});
	});

	grunt.registerTask( 'default', ['msgInitMerge', 'potomo', 'compress', 'createJSON'] );
};
