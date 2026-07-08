from transformers import AutoModelForCausalLM, AutoTokenizer

model_dir = "./results/fine-tuned-model"
model = AutoModelForCausalLM.from_pretrained(model_dir)
tokenizer = AutoTokenizer.from_pretrained(model_dir)

input_text = "def function_example():"
input_ids = tokenizer(input_text, return_tensors="pt").input_ids
output = model.generate(input_ids, max_length=100)

print(tokenizer.decode(output[0], skip_special_tokens=True))
