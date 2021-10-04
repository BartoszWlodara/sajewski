import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios'
import VueAxios from 'vue-axios'
import vueScrollBehavior from 'vue-scroll-behavior' 
import smoothscroll from 'smoothscroll-polyfill'
import VueI18n from 'vue-i18n'

//import VueLazyload from 'vue-lazyload'
//import 'http'
import instance from './http'
//import VueSplide from '@splidejs/vue-splide'; commented
//import { Icon } from 'ant-design-vue';
//import AxiosPlugin from 'vue-axios-cors'; commented

// kick off the polyfill!
smoothscroll.polyfill();  

Vue.config.productionTip = true

Vue.use(VueI18n, VueAxios, axios);

//Vue.component(Icon.name, Icon);

 


const messages = {
  en:{
    message:{
      bio: 'biography',
      work: 'works',
      exhb: 'exhibitions',
      auctions: 'auctions',
      contact: 'contact',
      biographyTitle: 'Biography',
      biographyPar_1: "(born 1957) in Częstochowa. From an early age, as a child noticed by a teacher, he participated in painting competitions. The natural path of the artist's development was his studies at the Academy of Fine Arts in the studio of Professor Niekrasz. The oldest paintings are the artist's favorite trend - magical realism. He created many works that traveled around the world and are in collections in Canada and the USA. He is inspired by music which has been with him for years and is locked up in his studio for long hours in its fumes. He composes pictures to the accompaniment of his favorite musicians such as Emerson Lake & Palmer, Pink Floyd, Archive, Dead Can Dance.",
      biographyPar_2: "Rediscovered after many years, he conquered the art market with his technique, ideas, vision and diversity. His career has been developing dynamically for several years. He has won over a large group of collectors who appreciate the artist for the sensuality shown in the art of ballet, for his perfectionism in underwater cities, for his creativity in magical realism and for his worldview shown in the march of equality.",
      biographyPar_3: 'He is a versatile artist. During his career, he created several hundred works. He constantly surprises his fans and creates for them unique works that decorate collections in the USA, Canada, Germany, France, Italy, Belgium and many other countries. When asked what had the greatest impact on his art, he replies "a burning giraffe". He traveled to his beloved Italy, there he tasted art right at the source. After many years in the ancient series, we can see how perfectly the artist feels among ancient statues and deities.',
      worksTitle: 'Gallery of Works',
      exhibiotonsTitle: 'Exhibitions',
      auctionsTitle: 'Auctions',
      arrangementsTitle: 'Customer arrangements',
      contactTitle: 'Contact',
      adminPanel: 'Admin panel',
      partnersTitle: 'Partners',
      Z_B_Title: 'Zdzisław Beksiński - my inspiration',
      Z_B_Description: 'As a high school student, I went to Mr. Zdzisław Beksiński, along with my father, who knew him personally. I showed him my painted works, asking for corrections. Already in high school, I painted pictures fascinated by the work of Beksiński. I enlisted the help of the Master as his student. He gave me tips and explained how to solve certain problems of composition and color. Zdzisław Beksiński had a great influence on my perception of art and the way I express myself through painting.',
      Auctions_Info: 'Please see the sales results of my paintings. I encourage you to follow the auction offers and auctions of the exhibited works.',
      Arrangement_Info: 'When standing at the easel, I always wonder what emotions I will arouse in the recipient and how the resulting image will acclimatize to the interior it will reach. I am interested in the creativity of my art lovers in arranging space. I am glad that the purchased works are starting to live their own lives in new homes, giving an astonishing aesthetic effect.',
      Contact_Info_Par1: 'To contact me, please fill in the form or send me an e-mail to the address below.',
      Contact_Info_Par2: 'Regards - Andrzej Andrea Sajewski.',
      Contact_Adress_Email: 'e-mail adress',
      HomePageSlider_Par1: "Yes, it's me",
      HomePageSlider_Par2: 'I create because I love, I create because it drives me to the rhythm of my favorite music and to the rhythm of the seasons. I have been creating imaginary worlds for explorers and magical lands for seekers of happiness since I was a child. I love delicacy, so I create portraits of beautiful and mysterious people, in thoughtfulness and delicate ballet, in underwater cities and desert sands. I am there, I am there for you. I share myself - I paint and create.',
      Send: "Send",
      ShowMore: 'Show more',
      placeholder_email: 'Email',
      placeholder_topic: 'Subject',
      placeholder_content: 'Content',
      EmailSuccess: 'Email has been sent.',
      EmailFail: 'Error during send message',
      EmailFail_captcha: 'There was a problem sending your message. Please try again later or send traditional E-mail.',
      NoAuctions: 'No new auctions',
      AuctionLink: 'Link to auction',
      TooShortEmail: 'Invalid E-mail.',
      TooShortTopic: 'The subject of the message must contain at least 10 characters.',
      TooShortContent: 'The content of the message is too short.',
      cookieMessage: 'This website uses cookies for statistical and functional purposes. By continuing to use the site, you agree to their use.'
    }
  },
  pl:{
    message:{
      bio: 'biografia',
      work: 'prace',
      exhb: 'wystawy',
      auctions: 'aukcje',
      contact: 'kontakt',
      biographyTitle: 'Biografia',
      biographyPar_1: '( ur.1957) w Częstochowie. Od najmłodszych lat, jako dziecko zauważony przez nauczyciela, brał udział w konkursach malarskich. Naturalną drogą rozwoju artysty były studia na Wyższej Szkole Plastycznej, w pracowni profesora Niekrasza. Najstarsze obrazy to ulubiony nurt artysty - realizm magiczny. Stworzył wiele prac, które powędrowały w świat i znajdują się w kolekcjach w Kanadzie i USA. Inspiruje się muzyką. Ona towarzyszy mu od lat i ginie w jej oparach na długie godziny, zamknięty w pracowni. Komponuje obrazy przy akompaniamencie swoich ulubionych muzyków jak Emerson Lake & Palmer, Pink Floyd, Archive, Dead Can Dance.',
      biographyPar_2: "Odkryty na nowo po wielu latach, zawojował rynek sztuki swoim warsztatem, pomysłami, wizją i różnorodnością. Od kilku lat następuje dynamiczny rozwój jego kariery. Zjednał sobie szerokie grono kolekcjonerów, którzy cenią artystę za zmysłowość ukazywaną w sztuce baletu, za perfekcjonizm w podwodnych miastach, za kreatywność w realizmie magicznym i za światopogląd ukazany w marszu równości.",
      biographyPar_3: 'Jest artystą wszechstronnym. W swojej karierze stworzył kilkaset dzieł. Stale zaskakuje swych fanów i tworzy dla nich unikatowe prace, które zdobią kolekcje w USA, Kanadzie, Niemczech, Francji, Włoszech, Belgii i wielu innych krajach. Zapytany o to co wywarło największy wpływ na jego sztukę - odpowiada "płonąca żyrafa". Podróżował, do swoich ukochanych Włoch, tam smakował sztukę bezpośrednio u źródła. Po wielu latach w serii antycznej widzimy jak doskonale artysta czuje się wśród antycznych posagów i bóstw.',
      worksTitle: 'Galeria Prac',
      exhibiotonsTitle: 'Wystawy',
      auctionsTitle: 'Aukcje',
      arrangementsTitle: 'Aranżacje klientów',
      contactTitle: 'Kontakt',
      adminPanel: 'Panel administracyjny',
      partnersTitle: 'Partnerzy',
      Z_B_Title: "Zdzisław Beksiński moją inspiracją",
      Z_B_Description: "Jako licealista jeździłem do Pana Zdzisława Beksińskiego, wraz z mym ojcem, który go znał osobiście. Pokazywałem mu swoje namalowane prace, prosząc o korekty. Już w liceum malowałem obrazy zafascynowany twórczością Beksińskiego. Korzystałem z pomocy Mistrza, będąc jego uczniem. Udzielał mi wskazówek i tłumaczył jak rozwiązywać pewne problemy kompozycji i kolorystyki. Zdzisław Beksiński miał duży wpływ na moje postrzeganie sztuki i sposób wyrażania się przez malarstwo.",
      Auctions_Info: 'Zapraszam do zapozniania się z wynikami sprzedaży moich obrazów. Zachęcam do śledzenia ofert aukcyjnych i licytacji wystawionych prac.',
      Arrangement_Info: 'Stojąc przy sztaludze, zawsze zastanawiam się jakie emocje wzbudzę u odbiorcy i jak powstający obraz zaaklimatyzuje się we wnętrzu, do którego trafi. Ciekawi mnie kreatywność miłośników mojej sztuki w aranżacji przestrzeni. Cieszę się, że zakupione prace zaczynają żyć własnym życiem w nowych domach, dając zdumiewający efekt estetyczny.',
      Contact_Info_Par1: 'Aby się ze mną skontaktować proszę wypełnić formularz, bądź wysłać do mnie e-mail na podany ponizej adres.',
      Contact_Info_Par2: 'Pozdrawiam - Andrzej Andrea Sajewski.',
      Contact_Adress_Email: 'Adres e-mail',
      HomePageSlider_Par1: 'Tak, to ja',
      HomePageSlider_Par2: 'Tworzę bo kocham, tworzę bo to mnie napędza w rytm ulubionej muzyki i w rytm pór roku. Tworzę od dziecka zmyślone światy dla odkrywców i magiczne krainy dla poszukiwaczy szczęścia. Kocham delikatność, więc tworzę portrety ludzi pięknych i zagadkowych, w zamyśleniu i delikatnym balecie, w podwodnych miastach i piaskach pustyni. Jestem tam ja, jestem tam dla was. Dzielę się sobą – maluję i tworzę.',
      Send: 'Wyślij',
      ShowMore: 'Pokaż więcej',
      placeholder_email: 'Email',
      placeholder_topic: 'Temat',
      placeholder_content: 'Treść',
      EmailSuccess: 'Wiadomość została wysłana.',
      EmailFail: 'Błąd wysyłania wiadomości.',
      EmailFail_captcha: 'Wystąpił problem podczas wysyłania wiadomości. Spróbuj ponownie później, lub wyślij tradycyjnego E-maila.',
      NoAuctions: 'Brak nowych aukcji',
      AuctionLink: 'Link do aukcji',
      TooShortEmail: 'Nieprawidłowy E-mail.',
      TooShortTopic: 'Temat wiadomości musi zawierać przynajmniej 10 znaków.',
      TooShortContent: 'Za krótka treść wiadomości.',
      cookieMessage: 'Ta strona wykorzystuje pliki cookies w celach statystycznych oraz funkcjonalych. Dalsze korzystanie ze strony oznacza, że zgadzasz się na ich użycie.'
    }
  },
  it:{
    message:{
      bio: 'biografia',
      work: 'lavori',
      exhb: 'mostre',
      auctions: 'aste',
      contact: 'contatto',
      biographyTitle: 'Biografia',
      biographyPar_1: "(nato nel 1957) a Częstochowa. Fin da piccolo, notato da un insegnante, partecipa a concorsi di pittura. Il percorso naturale dello sviluppo dell'artista sono stati poi i suoi studi presso l'Accademia di Belle Arti nello studio del professor Niekrasz. I dipinti più antichi sono la tendenza preferita dell'artista: il realismo magico. Ha creato molte opere che hanno viaggiato in tutto il mondo e sono in collezioni in Canada e negli Stati Uniti. Ispirato dalla musica. Sta con lui da anni, causandolo a perdersi nei suoi fumi per lunghe ore, chiuso in studio. Compone immagini conaccompagnamento dei suoi musicisti preferiti come Emerson Lake & Palmer, Pink Floyd, Archive, Dead Can Dance.",
      biographyPar_2: "Riscoperto dopo molti anni, ha conquistato il mercato dell'arte con la sua tecnica, le sue idee, la sua visione e la sua diversità. La sua carriera si è sviluppata in modo dinamico per diversi anni. Ha vinto un folto gruppo di collezionisti che lo apprezzano per sensualità mostrata nell'arte del balletto, per perfezionismo nelle città sottomarine, per creatività nel realismo magico e la visione del mondo mostrata nella marcia dell'uguaglianza.",
      biographyPar_3: "È un artista versatile. Durante la sua carriera, ha creato diverse centinaia di opere. Sorprende costantemente i suoi fan e crea per loro opere uniche che decorano collezioni negli Stati Uniti, in Canada, Germania, Francia, Italia, Belgio e molti altri paesi. Alla domanda su cosa abbia influenzato maggiormente la sua arte, risponde 'una giraffa in fiamme'. Ha viaggiato nella sua amata Italia, lì ha assaporato l'arte proprio alla fonte. Dopo molti anni nella serie antica possiamo vedere come l'artista si senta perfettamente a proprio agio tra statue e divinità antiche.",
      worksTitle: 'Galleria delle opere',
      exhibiotonsTitle: 'Mostre',
      auctionsTitle: 'Aste',
      arrangementsTitle: 'Disposizioni del cliente',
      contactTitle: 'Contatto',
      adminPanel: 'Pannello di amministrazione',
      partnersTitle: 'Partner',
      Z_B_Title: "Zdzisław Beksiński è la mia ispirazione",
      Z_B_Description: "Da studente delle superiori sono andato dal signor Zdzisław Beksiński, insieme a mio padre, che lo conosceva personalmente. Gli ho mostrato le mie opere dipinte, chiedendo correzioni. Già al liceo dipingevo quadri affascinato dall'arte di Beksiński. Ho arruolato l'aiuto del Maestro come suo allievo. Mi ha dato consigli e spiegato come risolvere alcuni problemi di composizione e colore. Zdzisław Beksiński ha avuto una grande influenza sulla mia percezione dell'arte e sul modo in cui mi sono espresso attraverso la pittura.",
      Auctions_Info: "Si prega di vedere i risultati di vendita dei miei dipinti. Vi incoraggio a seguire le offerte d'asta e le aste delle opere esposte.",
      Arrangement_Info: "Quando sono al cavalletto, mi chiedo sempre quali emozioni susciterò nel destinatario e come l'immagine risultante si adatterà all'interno a cui andrà a finire. Sono interessato alla creatività dei miei amanti dell'arte nell'organizzare lo spazio. Sono contento che le opere acquistate inizino a vivere la propria vita in nuove case, donando un effetto estetico sorprendente.",
      Contact_Info_Par1: "Per contattarmi, compila il modulo o inviami una e-mail all'indirizzo indicato di seguito.",
      Contact_Info_Par2: 'Saluti - Andrzej Andrea Sajewski.',
      Contact_Adress_Email: 'Indirizzo email',
      HomePageSlider_Par1: 'Sì, sono io',
      HomePageSlider_Par2: 'Creo perché amo, creo perché mi spinge al ritmo della mia musica preferita e al ritmo delle stagioni. Fin da bambino creo mondi immaginari per esploratori e terre magiche per cercatori di felicità. Amo la delicatezza, quindi creo ritratti di persone belle e misteriose, in delirio e delicati balletti, in città sottomarine e sabbie del deserto. Io sono lì, io sono lì per te. Condivido me stesso: dipingo e creo.',
      Send: 'Spedire',
      ShowMore: 'Mostra di più',
      placeholder_email: 'Email',
      placeholder_topic: 'Argomento',
      placeholder_content: 'Contenuti',
      EmailSuccess: 'Il messaggio è stato inviato.',
      EmailFail: 'Errore di invio del messaggio.',
      EmailFail_captcha: "Si è verificato un problema durante l'invio del messaggio. Riprova più tardi o invia un'e-mail tradizionale.",
      NoAuctions: 'Nessuna nuova asta',
      AuctionLink: "Link all'asta",
      TooShortEmail: "E-mail non valido",
      TooShortTopic: "L'oggetto del messaggio deve contenere almeno 10 caratteri",
      TooShortContent: 'Il contenuto del messaggio è troppo breve.',
      cookieMessage: 'Questo sito utilizza i cookie a fini statistici e funzionali. Continuando ad utilizzare il sito, acconsenti al loro utilizzo.'
    }
  }
}

const i18n = new VueI18n({
  locale: store.getters.GET_LANG,
  messages
});
new Vue({
  router,
  store,
  vueScrollBehavior, 
  watch:{
    $route (){
      if(store.getters.GET_AUTH_STATUS === 'logged'){
        instance.get('admin/fetchUser.php', {
          headers: {
              'Authorization': 'Bearer ' + localStorage.getItem('user-token')
          }
        }).then(() => {

          store.dispatch('FETCH_CURRENT_USER')
        })
      }
    }
  },
  render: h => h(App),
  i18n
}).$mount('#app')
