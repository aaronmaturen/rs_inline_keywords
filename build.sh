#!/bin/bash
# get current commit
git log | grep -m 1 commit
commit=`git log | grep -m 1 commit `
commitnick=${commit:7:10}
commitnick='0.7'
echo "updating version information in inline_keywords.yaml with latest git commit $commitnick"
sed -ibk "s/version: .*/version: $commitnick/" inline_keywords.yaml
rm inline_keywords.yamlbk
cd ..
rm inline_keywords*.rsp
cp -r rs_inline_keywords inline_keywords
tar -cz -f inline_keywords-$commitnick.rsp -X inline_keywords/exclude.txt inline_keywords
rm -rf inline_keywords

