link 
https://ripeseed.io/blog/fine-tuning-open-source-llm-llama-3-mistral-and-gemma

---------------


config/ollama.php

~~~php
return [
    'model' => env('OLLAMA_MODEL', 'llama2'),
    'url' => env('OLLAMA_URL', 'http://127.0.0.1:11434'),
    'default_prompt' => env('OLLAMA_DEFAULT_PROMPT', 'Hello, how can I assist you today?'),
    'connection' => [
        'timeout' => env('OLLAMA_CONNECTION_TIMEOUT', 300),
    ],
];
~~~


~~~bash
curl http://localhost:11434/api/generate -d '{
  "model": "llama3.1",
  "prompt":"Why is the sky blue?"
}'
~~~

~~~bash
pip install unsloth
pip install -U transformers accelerate
~~~

~~~json
dataset = [
    {"instruction": "Translate to French: Hello, how are you?", "output": "Bonjour, comment allez-vous?"},
    {"instruction": "Summarize this text: [Your long text here]", "output": "[Your summary here]"},
    # Add more examples...
]
~~~

