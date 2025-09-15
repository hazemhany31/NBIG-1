(function(){'use strict';const CONFIG={scrollThreshold:50,scrollToTopThreshold:300,socialBarOpacity:{mobile:{visible:1,hidden:0.8,threshold:60},desktop:{visible:1,hidden:0.7,threshold:100}},selectors:{header:'.header',contactForm:'#contact-form',successMessage:'#success-msg',menuToggle:'.menu-toggle',navMenu:'.nav-menu',socialBar:'.social-bar-simple',scrollToTop:'.scroll-to-top',loader:'#loader-overlay'}};const utils={throttle(fn,delay){let timeoutId;let lastExecTime=0;return function(...args){const currentTime=Date.now();if(currentTime-lastExecTime>delay){fn.apply(this,args);lastExecTime=currentTime}else{clearTimeout(timeoutId);timeoutId=setTimeout(()=>fn.apply(this,args),delay)}}},exists(selector){return document.querySelector(selector)!==null},getElement(selector){return document.querySelector(selector)},addEvent(element,event,handler,options={}){if(element){element.addEventListener(event,handler,options)}}};document.getElementById("contact-form").addEventListener("submit",function(e){e.preventDefault();var form=e.target;var formData=new FormData(form);fetch("https://script.google.com/macros/s/AKfycbyXMyFQ5rKOT0pcuMbqSaE4kxfKgcE-T3QefO_XarWl6EV8YE59uio8YgzZWdEiPQ-J/exec",{method:"POST",body:formData}).then(res=>res.text()).then(txt=>{if(txt.includes("Success")){document.getElementById("success-msg").style.display="block";form.reset();setTimeout(()=>{document.getElementById("success-msg").style.display="none"},5000)}else{alert("⚠️ حصل خطأ غير متوقع: "+txt)}}).catch(err=>{alert("❌ حدث خطأ أثناء الإرسال");console.error(err)})});class ContactFormHandler{constructor(){this.form=utils.getElement(CONFIG.selectors.contactForm);this.successMessage=utils.getElement(CONFIG.selectors.successMessage);this.init()}
init(){if(!this.form||!this.successMessage)return;utils.addEvent(this.form,'submit',this.handleSubmit.bind(this))}
handleSubmit(e){if(!this.form.hasAttribute('action')){e.preventDefault()}
this.showSuccessMessage();this.resetForm()}
showSuccessMessage(){this.successMessage.classList.add('visible');this.successMessage.style.display='inline';setTimeout(()=>{this.hideSuccessMessage()},5000)}
hideSuccessMessage(){this.successMessage.classList.remove('visible');this.successMessage.style.display='none'}
resetForm(){this.form.reset()}}
class HeaderHandler{constructor(){this.header=utils.getElement(CONFIG.selectors.header);this.init()}
init(){if(!this.header)return;const throttledScroll=utils.throttle(this.handleScroll.bind(this),16);utils.addEvent(window,'scroll',throttledScroll,{passive:!0})}
handleScroll(){const scrolled=window.scrollY>CONFIG.scrollThreshold;this.header.classList.toggle('scrolled',scrolled)}}
class MobileNavHandler{constructor(){this.menuToggle=utils.getElement(CONFIG.selectors.menuToggle);this.navMenu=utils.getElement(CONFIG.selectors.navMenu);this.init()}
init(){if(!this.menuToggle||!this.navMenu)return;utils.addEvent(this.menuToggle,'click',this.toggleMenu.bind(this));this.setupMenuLinks()}
toggleMenu(){const isOpen=this.navMenu.classList.contains('open');this.navMenu.classList.toggle('open');this.menuToggle.setAttribute('aria-expanded',!isOpen)}
closeMenu(){this.navMenu.classList.remove('open');this.menuToggle.setAttribute('aria-expanded','false')}
setupMenuLinks(){const links=this.navMenu.querySelectorAll('a');links.forEach(link=>{utils.addEvent(link,'click',()=>{if(this.navMenu.classList.contains('open')){this.closeMenu()}})})}}
class SmoothScrollHandler{constructor(){this.init()}
init(){const links=document.querySelectorAll('a[href^="#"]');links.forEach(link=>{utils.addEvent(link,'click',this.handleClick.bind(this))})}
handleClick(e){const targetId=e.currentTarget.getAttribute('href').slice(1);const target=document.getElementById(targetId);if(!target)return;e.preventDefault();const headerHeight=utils.getElement(CONFIG.selectors.header)?.offsetHeight||80;const targetPosition=target.getBoundingClientRect().top+window.scrollY-headerHeight;window.scrollTo({top:targetPosition,behavior:'smooth'})}}
class ScrollToTopHandler{constructor(){this.button=this.createButton();this.init()}
createButton(){let button=utils.getElement(CONFIG.selectors.scrollToTop);if(!button){button=document.createElement('button');button.className='scroll-to-top';button.setAttribute('aria-label','Scroll to top');button.innerHTML='<i class="fas fa-chevron-up"></i>';document.body.appendChild(button)}
return button}
init(){if(!this.button)return;utils.addEvent(this.button,'click',this.scrollToTop.bind(this));const throttledScroll=utils.throttle(this.handleScroll.bind(this),100);utils.addEvent(window,'scroll',throttledScroll,{passive:!0});utils.addEvent(window,'resize',this.updatePosition.bind(this));this.updatePosition();this.handleScroll()}
scrollToTop(){window.scrollTo({top:0,behavior:'smooth'})}
handleScroll(){const shouldShow=window.scrollY>CONFIG.scrollToTopThreshold;this.button.style.display=shouldShow?'flex':'none'}
updatePosition(){Object.assign(this.button.style,{right:'20px',left:'',bottom:'20px',transform:'',width:'50px',height:'50px',fontSize:'1.2em'})}}
class SocialBarHandler{constructor(){this.socialBar=utils.getElement(CONFIG.selectors.socialBar);this.init()}
init(){if(!this.socialBar)return;utils.addEvent(window,'resize',this.updatePosition.bind(this));const throttledScroll=utils.throttle(this.handleScroll.bind(this),100);utils.addEvent(window,'scroll',throttledScroll,{passive:!0});this.updatePosition()}
updatePosition(){const isMobile=window.innerWidth<=600;if(isMobile){Object.assign(this.socialBar.style,{position:'fixed',top:'',left:'50%',bottom:'0',transform:'translateX(-50%)',flexDirection:'row',padding:'8px 12px',borderRadius:'12px 12px 0 0'})}else{Object.assign(this.socialBar.style,{position:'fixed',top:'50%',left:'12px',bottom:'',transform:'translateY(-50%)',flexDirection:'column',padding:'13px 7px',borderRadius:'9px'})}}
handleScroll(){const isMobile=window.innerWidth<=600;const config=isMobile?CONFIG.socialBarOpacity.mobile:CONFIG.socialBarOpacity.desktop;const opacity=window.scrollY>config.threshold?config.visible:config.hidden;this.socialBar.style.opacity=opacity}}
class LoaderHandler{constructor(){this.loader=utils.getElement(CONFIG.selectors.loader);this.init()}
init(){if(!this.loader)return;if(document.readyState==='loading'){utils.addEvent(window,'load',this.hideLoader.bind(this))}else{this.hideLoader()}}
hideLoader(){if(!this.loader)return;this.loader.classList.add('hide');setTimeout(()=>{if(this.loader.parentNode){this.loader.parentNode.removeChild(this.loader)}},700)}}
class App{constructor(){this.init()}
init(){try{new ContactFormHandler();new HeaderHandler();new MobileNavHandler();new SmoothScrollHandler();new ScrollToTopHandler();new SocialBarHandler();new LoaderHandler();console.log('NBIG Website initialized successfully')}catch(error){console.warn('Some features may not work correctly:',error)}}}
function initApp(){if(document.readyState==='loading'){document.addEventListener('DOMContentLoaded',()=>new App())}else{new App()}}
initApp()})()