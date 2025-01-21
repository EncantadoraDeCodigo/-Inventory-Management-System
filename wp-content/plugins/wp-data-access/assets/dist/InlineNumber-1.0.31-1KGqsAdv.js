import{j as a}from"./cm-1.0.31-BzgG35ZX.js";import{N as h}from"./react-number-format.es-1.0.31-BqNlp_-j.js";import{e as g}from"./notistack-1.0.31-CuGQWCbt.js";import{l as b,ce as C,C as j}from"./lib-1.0.31-BbX3jq4e.js";import{g as k}from"./TableQuery-1.0.31-s1kaUzCT.js";import{T as w}from"./TextField-1.0.31-TtMrk-_t.js";import"./redux-1.0.31-CuzmJMK6.js";import"./vendor-1.0.31-BmpNFhoq.js";import"./loglevel-1.0.31-BZ7XahX3.js";import"./lodash-1.0.31-BtCjXqrS.js";import"./moment-1.0.31-C5S46NFB.js";import"./main-1.0.31.js";import"./useStoreTable-1.0.31-CksmwD3u.js";import"./RestApi-1.0.31-C4KxgDIV.js";import"./index-1.0.31-C4m7fjwq.js";import"./cjs-1.0.31-B-_HdexB.js";import"./Typography-1.0.31-BdhCS1KD.js";import"./iconBase-1.0.31-C37NsRUm.js";import"./ActionsDml-1.0.31-DnIQKtBi.js";import"./ConfirmDialog-1.0.31-bZDmgpd0.js";import"./AdminTheme-1.0.31-QbwKcRV7.js";import"./DialogContent-1.0.31-_6ykng6a.js";import"./SanitizeComponent-1.0.31-Dhv0AQbJ.js";import"./dompurify-1.0.31-CCJo14B2.js";import"./index-1.0.31-C_6FsHsh.js";import"./tanstack-1.0.31-DxTNlTkm.js";import"./index.esm-1.0.31-BlNbk2TL.js";import"./createSvgIcon-1.0.31-BC4iq9Gi.js";import"./index-1.0.31-DboOrfK9.js";import"./Collapse-1.0.31-CkBm-DA4.js";import"./Tooltip-1.0.31-crORCg22.js";import"./Popper-1.0.31-QmfursjS.js";import"./useControlled-1.0.31-27-LkxG9.js";import"./Spinner-1.0.31-Be7r01J6.js";import"./FormControlLabel-1.0.31-VNfgE3Oe.js";import"./useFormControl-1.0.31-2YJOQA8g.js";import"./Checkbox-1.0.31-vMcA9dS9.js";import"./SwitchBase-1.0.31-AIM_3--O.js";import"./Menu-1.0.31-BOTBPSPr.js";import"./InputAdornment-1.0.31-DPyTBX7W.js";import"./Autocomplete-1.0.31-DLbMViDM.js";import"./Close-1.0.31-BTPwVQpD.js";import"./TimePicker-1.0.31-BANN2pIs.js";import"./useMobilePicker-1.0.31-DH3b4aWb.js";import"./index-1.0.31-545nqCBP.js";import"./FormHelperText-1.0.31-CQcG9a5q.js";import"./visuallyHidden-1.0.31-Dan1xhjv.js";import"./ListItem-1.0.31-CWrAezii.js";import"./timeViewRenderers-1.0.31-CeUACARG.js";import"./MenuItem-1.0.31-CTowyoSp.js";import"./DateTimePicker-1.0.31-D95kRUCa.js";import"./Tabs-1.0.31-XRJEidP6.js";import"./dateViewRenderers-1.0.31-B5XFWF81.js";import"./Divider-1.0.31-BWKAGEdz.js";import"./DatePicker-1.0.31-wKpNLdLs.js";import"./Stack-1.0.31-Bz9nXUZB.js";import"./Slider-1.0.31-BDZ4XVru.js";import"./ListItemIcon-1.0.31-BCafYY7N.js";import"./Radio-1.0.31-DbEe8Ljo.js";import"./AlertTitle-1.0.31-Zosaacrw.js";import"./Switch-1.0.31-LPOyRUXk.js";import"./index.esm-1.0.31-BcBy0Voo.js";import"./useTheme-1.0.31-BXg8i2QZ.js";import"./TableContainer-1.0.31-D5nXSZNu.js";import"./FallbackSpinner-1.0.31-B4qqxHwC.js";import"./ActionsSettings-1.0.31-Cf56Toxs.js";import"./TargetEnum-1.0.31-DPFnTxiX.js";import"./ScopeEnum-1.0.31-B4DDvIDj.js";import"./index-1.0.31-ujFQUobk.js";import"./TabPanel-1.0.31-CQFpWPRX.js";import"./useTableUpdater-1.0.31-BVeL37Z7.js";import"./settings-1.0.31-zyRrYuee.js";import"./useScreenSize-1.0.31-DKas25yF.js";import"./ThemeContainer-1.0.31-D01zq5BI.js";import"./useTableColumnOrder-1.0.31-CvAinKiB.js";import"./FormLabel-1.0.31-7Vju-x1c.js";const Wi=({value:e,columnState:i,columnMetaData:o,setValue:f,saveChanges:n,cancel:I,setButtons:d,locale:p,language:m})=>{b.debug(e,i,o);const N=parseInt(o.numeric_scale),t={};(i==null?void 0:i.inlineNumericMin)!==void 0&&(t.min=i.inlineNumericMin),(i==null?void 0:i.inlineNumericMax)!==void 0&&(t.max=i.inlineNumericMax);const x=C((m==null?void 0:m.code)??j.defaultLanguage.code);return a.jsx("div",{onClick:r=>{r.stopPropagation()},onKeyDown:r=>{r.stopPropagation()},children:a.jsx(h,{customInput:w,className:"pp-inline-editing",value:e??"",thousandSeparator:i.localize?x.thousandSeperator:void 0,decimalSeparator:i.localize?x.decimalSeperator:void 0,decimalScale:N,required:o.is_nullable==="NO",slotProps:{htmlInput:t},variant:"outlined",prefix:(i==null?void 0:i.prefix)??"",suffix:(i==null?void 0:i.suffix)??"",placeholder:((i==null?void 0:i.prefix)??"")+"9.999,99"+((i==null?void 0:i.suffix)??""),onValueChange:({value:r})=>{r===""&&o.is_nullable!=="NO"?f(null):f(r)},onKeyDown:r=>{if(r.key==="Enter"){let s=!0;r.target.value!==""&&(r.target.min&&parseInt(r.target.value)<parseInt(r.target.min)&&(g((p==null?void 0:p.minAllowed)+" "+r.target.min,{variant:"error"}),s=!1),r.target.max&&parseInt(r.target.value)>parseInt(r.target.max)&&(g((p==null?void 0:p.maxAllowed)+" "+r.target.max,{variant:"error"}),s=!1)),s&&n()}else r.key==="Escape"&&I()},onFocus:()=>{d(!0)},onBlur:()=>{setTimeout(()=>{d(!1)},200)},sx:k(i)})})};export{Wi as default};
