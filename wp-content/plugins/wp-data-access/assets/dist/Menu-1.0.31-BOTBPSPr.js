import{r as l}from"./redux-1.0.31-CuzmJMK6.js";import{g as Q,f as Z,i as H,n as ee,c as V,o as te,r as Ie}from"./Typography-1.0.31-BdhCS1KD.js";import{u as $e}from"./AdminTheme-1.0.31-QbwKcRV7.js";import{j as z}from"./cm-1.0.31-BzgG35ZX.js";import{b as ke,a as be,P as De,d as pe}from"./iconBase-1.0.31-C37NsRUm.js";import{a5 as Fe,z as Y,a1 as J,F as Oe,a0 as ze,O as de}from"./cjs-1.0.31-B-_HdexB.js";var G={exports:{}},s={};/**
 * @license React
 * react-is.production.min.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */var me;function je(){if(me)return s;me=1;var e=Symbol.for("react.element"),t=Symbol.for("react.portal"),r=Symbol.for("react.fragment"),h=Symbol.for("react.strict_mode"),p=Symbol.for("react.profiler"),a=Symbol.for("react.provider"),d=Symbol.for("react.context"),u=Symbol.for("react.server_context"),f=Symbol.for("react.forward_ref"),b=Symbol.for("react.suspense"),M=Symbol.for("react.suspense_list"),x=Symbol.for("react.memo"),R=Symbol.for("react.lazy"),i=Symbol.for("react.offscreen"),S;S=Symbol.for("react.module.reference");function P(o){if(typeof o=="object"&&o!==null){var c=o.$$typeof;switch(c){case e:switch(o=o.type,o){case r:case p:case h:case b:case M:return o;default:switch(o=o&&o.$$typeof,o){case u:case d:case f:case R:case x:case a:return o;default:return c}}case t:return c}}}return s.ContextConsumer=d,s.ContextProvider=a,s.Element=e,s.ForwardRef=f,s.Fragment=r,s.Lazy=R,s.Memo=x,s.Portal=t,s.Profiler=p,s.StrictMode=h,s.Suspense=b,s.SuspenseList=M,s.isAsyncMode=function(){return!1},s.isConcurrentMode=function(){return!1},s.isContextConsumer=function(o){return P(o)===d},s.isContextProvider=function(o){return P(o)===a},s.isElement=function(o){return typeof o=="object"&&o!==null&&o.$$typeof===e},s.isForwardRef=function(o){return P(o)===f},s.isFragment=function(o){return P(o)===r},s.isLazy=function(o){return P(o)===R},s.isMemo=function(o){return P(o)===x},s.isPortal=function(o){return P(o)===t},s.isProfiler=function(o){return P(o)===p},s.isStrictMode=function(o){return P(o)===h},s.isSuspense=function(o){return P(o)===b},s.isSuspenseList=function(o){return P(o)===M},s.isValidElementType=function(o){return typeof o=="string"||typeof o=="function"||o===r||o===p||o===h||o===b||o===M||o===i||typeof o=="object"&&o!==null&&(o.$$typeof===R||o.$$typeof===x||o.$$typeof===a||o.$$typeof===d||o.$$typeof===f||o.$$typeof===S||o.getModuleId!==void 0)},s.typeOf=P,s}var he;function Ke(){return he||(he=1,G.exports=je()),G.exports}Ke();function Ne(e,t=166){let r;function h(...p){const a=()=>{e.apply(this,p)};clearTimeout(r),r=setTimeout(a,t)}return h.clear=()=>{clearTimeout(r)},h}function He(e){return typeof e=="string"}const _e=l.createContext({});function Ae(e){return Z("MuiList",e)}Q("MuiList",["root","padding","dense","subheader"]);const Ue=e=>{const{classes:t,disablePadding:r,dense:h,subheader:p}=e;return te({root:["root",!r&&"padding",h&&"dense",p&&"subheader"]},Ae,t)},We=H("ul",{name:"MuiList",slot:"Root",overridesResolver:(e,t)=>{const{ownerState:r}=e;return[t.root,!r.disablePadding&&t.padding,r.dense&&t.dense,r.subheader&&t.subheader]}})({listStyle:"none",margin:0,padding:0,position:"relative",variants:[{props:({ownerState:e})=>!e.disablePadding,style:{paddingTop:8,paddingBottom:8}},{props:({ownerState:e})=>e.subheader,style:{paddingTop:0}}]}),qe=l.forwardRef(function(t,r){const h=ee({props:t,name:"MuiList"}),{children:p,className:a,component:d="ul",dense:u=!1,disablePadding:f=!1,subheader:b,...M}=h,x=l.useMemo(()=>({dense:u}),[u]),R={...h,component:d,dense:u,disablePadding:f},i=Ue(R);return z.jsx(_e.Provider,{value:x,children:z.jsxs(We,{as:d,className:V(i.root,a),ref:r,ownerState:R,...M,children:[b,p]})})});function B(e,t,r){return e===t?e.firstChild:t&&t.nextElementSibling?t.nextElementSibling:r?null:e.firstChild}function ye(e,t,r){return e===t?r?e.firstChild:e.lastChild:t&&t.previousElementSibling?t.previousElementSibling:r?null:e.lastChild}function Se(e,t){if(t===void 0)return!0;let r=e.innerText;return r===void 0&&(r=e.textContent),r=r.trim().toLowerCase(),r.length===0?!1:t.repeating?r[0]===t.keys[0]:r.startsWith(t.keys.join(""))}function A(e,t,r,h,p,a){let d=!1,u=p(e,t,t?r:!1);for(;u;){if(u===e.firstChild){if(d)return!1;d=!0}const f=h?!1:u.disabled||u.getAttribute("aria-disabled")==="true";if(!u.hasAttribute("tabindex")||!Se(u,a)||f)u=p(e,u,r);else return u.focus(),!0}return!1}const Ve=l.forwardRef(function(t,r){const{actions:h,autoFocus:p=!1,autoFocusItem:a=!1,children:d,className:u,disabledItemsFocusable:f=!1,disableListWrap:b=!1,onKeyDown:M,variant:x="selectedMenu",...R}=t,i=l.useRef(null),S=l.useRef({keys:[],repeating:!0,previousKeyMatched:!0,lastTime:null});ke(()=>{p&&i.current.focus()},[p]),l.useImperativeHandle(h,()=>({adjustStyleForScrollbar:(n,{direction:m})=>{const v=!i.current.style.width;if(n.clientHeight<i.current.clientHeight&&v){const k=`${Fe(Y(n))}px`;i.current.style[m==="rtl"?"paddingLeft":"paddingRight"]=k,i.current.style.width=`calc(100% + ${k})`}return i.current}}),[]);const P=n=>{const m=i.current,v=n.key;if(n.ctrlKey||n.metaKey||n.altKey){M&&M(n);return}const T=J(m).activeElement;if(v==="ArrowDown")n.preventDefault(),A(m,T,b,f,B);else if(v==="ArrowUp")n.preventDefault(),A(m,T,b,f,ye);else if(v==="Home")n.preventDefault(),A(m,null,b,f,B);else if(v==="End")n.preventDefault(),A(m,null,b,f,ye);else if(v.length===1){const y=S.current,E=v.toLowerCase(),O=performance.now();y.keys.length>0&&(O-y.lastTime>500?(y.keys=[],y.repeating=!0,y.previousKeyMatched=!0):y.repeating&&E!==y.keys[0]&&(y.repeating=!1)),y.lastTime=O,y.keys.push(E);const D=T&&!y.repeating&&Se(T,y);y.previousKeyMatched&&(D||A(m,T,!1,f,B,y))?n.preventDefault():y.previousKeyMatched=!1}M&&M(n)},o=be(i,r);let c=-1;l.Children.forEach(d,(n,m)=>{if(!l.isValidElement(n)){c===m&&(c+=1,c>=d.length&&(c=-1));return}n.props.disabled||(x==="selectedMenu"&&n.props.selected||c===-1)&&(c=m),c===m&&(n.props.disabled||n.props.muiSkipListHighlight||n.type.muiSkipListHighlight)&&(c+=1,c>=d.length&&(c=-1))});const $=l.Children.map(d,(n,m)=>{if(m===c){const v={};return a&&(v.autoFocus=!0),n.props.tabIndex===void 0&&x==="selectedMenu"&&(v.tabIndex=0),l.cloneElement(n,v)}return n});return z.jsx(qe,{role:"menu",ref:o,className:u,onKeyDown:P,tabIndex:p?0:-1,...R,children:$})});function Ge(e){return Z("MuiPopover",e)}Q("MuiPopover",["root","paper"]);function ge(e,t){let r=0;return typeof t=="number"?r=t:t==="center"?r=e.height/2:t==="bottom"&&(r=e.height),r}function ve(e,t){let r=0;return typeof t=="number"?r=t:t==="center"?r=e.width/2:t==="right"&&(r=e.width),r}function Pe(e){return[e.horizontal,e.vertical].map(t=>typeof t=="number"?`${t}px`:t).join(" ")}function X(e){return typeof e=="function"?e():e}const Be=e=>{const{classes:t}=e;return te({root:["root"],paper:["paper"]},Ge,t)},Xe=H(Oe,{name:"MuiPopover",slot:"Root",overridesResolver:(e,t)=>t.root})({}),Me=H(De,{name:"MuiPopover",slot:"Paper",overridesResolver:(e,t)=>t.paper})({position:"absolute",overflowY:"auto",overflowX:"hidden",minWidth:16,minHeight:16,maxWidth:"calc(100% - 32px)",maxHeight:"calc(100% - 32px)",outline:0}),Ye=l.forwardRef(function(t,r){const h=ee({props:t,name:"MuiPopover"}),{action:p,anchorEl:a,anchorOrigin:d={vertical:"top",horizontal:"left"},anchorPosition:u,anchorReference:f="anchorEl",children:b,className:M,container:x,elevation:R=8,marginThreshold:i=16,open:S,PaperProps:P={},slots:o={},slotProps:c={},transformOrigin:$={vertical:"top",horizontal:"left"},TransitionComponent:n=ze,transitionDuration:m="auto",TransitionProps:{onEntering:v,...k}={},disableScrollLock:T=!1,...y}=h,E=(c==null?void 0:c.paper)??P,O=l.useRef(),D={...h,anchorOrigin:d,anchorReference:f,elevation:R,marginThreshold:i,externalPaperSlotProps:E,transformOrigin:$,TransitionComponent:n,transitionDuration:m,TransitionProps:k},_=Be(D),U=l.useCallback(()=>{if(f==="anchorPosition")return u;const g=X(a),C=(g&&g.nodeType===1?g:J(O.current).body).getBoundingClientRect();return{top:C.top+ge(C,d.vertical),left:C.left+ve(C,d.horizontal)}},[a,d.horizontal,d.vertical,u,f]),W=l.useCallback(g=>({vertical:ge(g,$.vertical),horizontal:ve(g,$.horizontal)}),[$.horizontal,$.vertical]),q=l.useCallback(g=>{const w={width:g.offsetWidth,height:g.offsetHeight},C=W(w);if(f==="none")return{top:null,left:null,transformOrigin:Pe(C)};const ie=U();let K=ie.top-C.vertical,N=ie.left-C.horizontal;const ae=K+w.height,le=N+w.width,ce=Y(X(a)),ue=ce.innerHeight-i,fe=ce.innerWidth-i;if(i!==null&&K<i){const I=K-i;K-=I,C.vertical+=I}else if(i!==null&&ae>ue){const I=ae-ue;K-=I,C.vertical+=I}if(i!==null&&N<i){const I=N-i;N-=I,C.horizontal+=I}else if(le>fe){const I=le-fe;N-=I,C.horizontal+=I}return{top:`${Math.round(K)}px`,left:`${Math.round(N)}px`,transformOrigin:Pe(C)}},[a,f,U,W,i]),[L,j]=l.useState(S),F=l.useCallback(()=>{const g=O.current;if(!g)return;const w=q(g);w.top!==null&&g.style.setProperty("top",w.top),w.left!==null&&(g.style.left=w.left),g.style.transformOrigin=w.transformOrigin,j(!0)},[q]);l.useEffect(()=>(T&&window.addEventListener("scroll",F),()=>window.removeEventListener("scroll",F)),[a,T,F]);const we=(g,w)=>{v&&v(g,w),F()},xe=()=>{j(!1)};l.useEffect(()=>{S&&F()}),l.useImperativeHandle(p,()=>S?{updatePosition:()=>{F()}}:null,[S,F]),l.useEffect(()=>{if(!S)return;const g=Ne(()=>{F()}),w=Y(a);return w.addEventListener("resize",g),()=>{g.clear(),w.removeEventListener("resize",g)}},[a,S,F]);let oe=m;m==="auto"&&!n.muiSupportAuto&&(oe=void 0);const Re=x||(a?J(X(a)).body:void 0),re={slots:o,slotProps:{...c,paper:E}},[Ce,ne]=pe("paper",{elementType:Me,externalForwardedProps:re,additionalProps:{elevation:R,className:V(_.paper,E==null?void 0:E.className),style:L?E.style:{...E.style,opacity:0}},ownerState:D}),[se,{slotProps:Ee,...Le}]=pe("root",{elementType:Xe,externalForwardedProps:re,additionalProps:{slotProps:{backdrop:{invisible:!0}},container:Re,open:S},ownerState:D,className:V(_.root,M)}),Te=be(O,ne.ref);return z.jsx(se,{...Le,...!He(se)&&{slotProps:Ee,disableScrollLock:T},...y,ref:r,children:z.jsx(n,{appear:!0,in:S,onEntering:we,onExited:xe,timeout:oe,...k,children:z.jsx(Ce,{...ne,ref:Te,children:b})})})});function Je(e){return Z("MuiMenu",e)}Q("MuiMenu",["root","paper","list"]);const Qe={vertical:"top",horizontal:"right"},Ze={vertical:"top",horizontal:"left"},et=e=>{const{classes:t}=e;return te({root:["root"],paper:["paper"],list:["list"]},Je,t)},tt=H(Ye,{shouldForwardProp:e=>Ie(e)||e==="classes",name:"MuiMenu",slot:"Root",overridesResolver:(e,t)=>t.root})({}),ot=H(Me,{name:"MuiMenu",slot:"Paper",overridesResolver:(e,t)=>t.paper})({maxHeight:"calc(100% - 96px)",WebkitOverflowScrolling:"touch"}),rt=H(Ve,{name:"MuiMenu",slot:"List",overridesResolver:(e,t)=>t.list})({outline:0}),ut=l.forwardRef(function(t,r){const h=ee({props:t,name:"MuiMenu"}),{autoFocus:p=!0,children:a,className:d,disableAutoFocusItem:u=!1,MenuListProps:f={},onClose:b,open:M,PaperProps:x={},PopoverClasses:R,transitionDuration:i="auto",TransitionProps:{onEntering:S,...P}={},variant:o="selectedMenu",slots:c={},slotProps:$={},...n}=h,m=$e(),v={...h,autoFocus:p,disableAutoFocusItem:u,MenuListProps:f,onEntering:S,PaperProps:x,transitionDuration:i,TransitionProps:P,variant:o},k=et(v),T=p&&!u&&M,y=l.useRef(null),E=(L,j)=>{y.current&&y.current.adjustStyleForScrollbar(L,{direction:m?"rtl":"ltr"}),S&&S(L,j)},O=L=>{L.key==="Tab"&&(L.preventDefault(),b&&b(L,"tabKeyDown"))};let D=-1;l.Children.map(a,(L,j)=>{l.isValidElement(L)&&(L.props.disabled||(o==="selectedMenu"&&L.props.selected||D===-1)&&(D=j))});const _=c.paper??ot,U=$.paper??x,W=de({elementType:c.root,externalSlotProps:$.root,ownerState:v,className:[k.root,d]}),q=de({elementType:_,externalSlotProps:U,ownerState:v,className:k.paper});return z.jsx(tt,{onClose:b,anchorOrigin:{vertical:"bottom",horizontal:m?"right":"left"},transformOrigin:m?Qe:Ze,slots:{paper:_,root:c.root},slotProps:{root:W,paper:q},open:M,ref:r,transitionDuration:i,TransitionProps:{onEntering:E,...P},ownerState:v,...n,classes:R,children:z.jsx(rt,{onKeyDown:O,actions:y,autoFocus:p&&(D===-1||u),autoFocusItem:T,variant:o,...f,className:V(k.list,f.className),children:a})})});export{_e as L,ut as M,Ye as P,qe as a,Ve as b,Ne as d,He as i};
