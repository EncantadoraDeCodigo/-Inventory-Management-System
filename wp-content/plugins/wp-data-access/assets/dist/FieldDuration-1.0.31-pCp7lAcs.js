import{j as O}from"./cm-1.0.31-BzgG35ZX.js";import{P as c}from"./react-number-format.es-1.0.31-BqNlp_-j.js";import{l as y,cb as h,cd as E,cc as R,W as n,U as f}from"./lib-1.0.31-BbX3jq4e.js";import{a as P}from"./RestApi-1.0.31-C4KxgDIV.js";import{T as j}from"./TextField-1.0.31-TtMrk-_t.js";import"./redux-1.0.31-CuzmJMK6.js";import"./vendor-1.0.31-BmpNFhoq.js";import"./loglevel-1.0.31-BZ7XahX3.js";import"./lodash-1.0.31-BtCjXqrS.js";import"./moment-1.0.31-C5S46NFB.js";import"./Typography-1.0.31-BdhCS1KD.js";import"./iconBase-1.0.31-C37NsRUm.js";import"./FormHelperText-1.0.31-CQcG9a5q.js";import"./useFormControl-1.0.31-2YJOQA8g.js";import"./cjs-1.0.31-B-_HdexB.js";import"./notistack-1.0.31-CuGQWCbt.js";import"./FormLabel-1.0.31-7Vju-x1c.js";import"./Menu-1.0.31-BOTBPSPr.js";import"./AdminTheme-1.0.31-QbwKcRV7.js";import"./useControlled-1.0.31-27-LkxG9.js";import"./createSvgIcon-1.0.31-BC4iq9Gi.js";const Z=({appId:p,columnName:t,columnValue:l,columnMetaData:e,storeColumn:r,columnValidation:s,onColumnChange:x,metaData:b,storeForm:T,formMode:g,locale:m,language:a})=>{y.debug(p,t,l,e,r,s,b,T,g,m,a);const o=P(),d={readOnly:h(b,e,r,g)};return O.jsx(c,{customInput:j,error:s==null?void 0:s.error,label:e.formLabel,value:l??"",required:e.is_nullable==="NO",slotProps:{htmlInput:d},className:r.classNames,helperText:E(r,m.enterTime),variant:R(),onValueChange:({value:i})=>{if(i===""&&e.is_nullable!=="NO")x(t,null),o(n({appId:p,columnName:t,columnError:!1,columnText:"",columnType:f.FORM}));else{x(t,(i+"000000").substring(0,6));let u=i.substring(2,3),F=i.substring(4,5);Number(u)>5||Number(F)>5?o(n({appId:p,columnName:t,columnError:!0,columnText:m.mandatoryField,columnType:f.FORM})):o(n({appId:p,columnName:t,columnError:!1,columnText:"",columnType:f.FORM}))}},onInvalid:i=>{i.preventDefault()},prefix:(r==null?void 0:r.prefix)??"",sx:{"& input":{textAlign:r.alignment}},format:"##:##:##",placeholder:"00:00:00"})};export{Z as default};
