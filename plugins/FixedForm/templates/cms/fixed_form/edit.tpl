{% extends "master.tpl" %}

{% block head %}
  <link rel="stylesheet" href="{{ config.global.assets_path }}style/cms/default.css">
{% endblock %}

{% block main %}
<p id="backlink"><a href="?mode=fixed-form~response">一覧に戻る</a></p>
<div class="wrapper">
  <h1>定型文編集</h1>
  {% if err.vl_title == 1 %}
    <div class="error">
      <i>入力してください</i>
    </div>
  {% endif %}
  <div class="fieldset{% if err.vl_title == 1 %} invalid{% endif %}">
    <label for="title">名称</label>
    <input type="text" name="title" id="title" value="{{ post.title }}" placeholder="分かりやすい名前をつけてください">
  </div>

  <div class="fieldset">
    <label for="content">本文</label>
    <textarea name="content" id="content">{{ post.content }}</textarea>
  </div>

  <div class="fieldset">
    <label for="tags">タイプ</label>
    <input type="text" name="tags" id="tags" value="{{ post.tags }}">
  </div>

  {% include 'edit_form_metadata.tpl' %}

  <div class="form-footer">
    <input type="submit" name="s1_submit" value="登録">
    <input type="hidden" name="mode" value="fixed-form~receive:save">
    <input type="hidden" name="id" value="{{ post.id }}">
  </div>

</div>
{% endblock %}
