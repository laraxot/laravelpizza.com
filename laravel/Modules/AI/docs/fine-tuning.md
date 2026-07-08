 
https://apeatling.com/articles/part-2-building-your-training-data-for-fine-tuning/

https://apeatling.com/articles/part-3-fine-tuning-your-llm-using-the-mlx-framework/

https://medium.com/@meirgotroot/bringing-your-fine-tuned-mlx-model-to-life-with-ollama-integration-c54274de6491

https://www.restack.io/p/fine-tuning-answer-ollama-cat-ai

https://quickcreator.io/quthor_blog/fine-tuning-ollama-models-customized-applications/

https://ravinkumar.com/GenAiGuidebook/deepdive/SmallModelFinetuning.html


https://medium.com/aimonks/code-llama-quick-start-guide-and-prompt-engineering-eb1de8758399


~~~bash
python3 -m venv venv
source venv/bin/activate
pip install flask pandas torch transformers mlx-lm tensorflow
~~~

Flask: Per creare l'API che riceve le richieste POST da Laravel.
Pandas: Per la gestione dei dataset (CSV, JSON, Markdown).
Transformers e torch: Per gestire i modelli di NLP e il fine-tuning.

~~~bash
python fine_tuning.py
~~~

~~~bash
curl -X POST http://localhost:5000/fine-tune \
-H "Content-Type: application/json" \
-d '{
    "dataset_file": [
        {"text": "First example sentence for fine-tuning."},
        {"text": "Second example sentence for fine-tuning."},
        {"text": "Third example sentence for fine-tuning."}
    ],
    "file_format": "json",
    "learning_rate": 0.00001,
    "batch_size": 8,
    "epochs": 3
}'
~~~







