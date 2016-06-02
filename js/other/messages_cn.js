/*
 * Translated default messages for the jQuery validation plugin.
 * Locale: CN
 */
jQuery.extend(jQuery.validator.messages, {
        required: "必填内容",
		remote: "请修正该字段",
		email: "请输入正确格式的电子邮箱",
		url: "请输入正确的网址",
		date: "请输入正确的日期",
		dateISO: "请输入正确的日期 (ISO).",
		number: "请输入正确的数字",
		digits: "只能输入整数",
		creditcard: "请输入正确的信用卡号",
		equalTo: "请再次输入相同的值",
		accept: "请输入拥有正确后缀名的字符串",
		maxlength: jQuery.validator.format("请最多输入 {0} 个字"),
		minlength: jQuery.validator.format("请最少输入 {0} 个字"),
		rangelength: jQuery.validator.format("请输入介于 {0} 至 {1} 个字"),
		range: jQuery.validator.format("请输入一个介于 {0} 和 {1} 之间的值"),
		max: jQuery.validator.format("请输入一个最大为 {0} 的值"),
		min: jQuery.validator.format("请输入一个最小为 {0} 的值")
});

jQuery.validator.setDefaults({
    errorElement: "span",
    errorClass: 'help-inline',
    errorPlacement: function (error, element) {
        if (error != null && error.text().length > 0) {
            element.tooltip({ title: error.text(), delay: { show: 100, hide: 100 }, trigger: 'manual', placement: 'top',container:'body' })
            	.tooltip('show');
            window.setTimeout(function () { element.tooltip('destroy'); }, 3000);
        } else {
            element.tooltip('destroy');
        }
    }, success: function () {
        $(this).next().tooltip('destroy');
    }
});